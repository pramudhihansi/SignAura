"""
SignAura Flask API Server
Provides REST endpoints for sign language recognition
"""

from flask import Flask, request, jsonify
from flask_cors import CORS
import os
from datetime import datetime
from inference import SignLanguageInference

# Initialize Flask app
app = Flask(__name__)

# Configure CORS (allow requests from PHP frontend)
# Configure CORS (allow requests from any frontend port)
CORS(app, resources={r"/*": {"origins": "*"}})

# Load environment variables
API_PORT = int(os.getenv('API_PORT', 5000))
API_DEBUG = os.getenv('API_DEBUG', 'True') == 'True'

# Model paths (relative to api/ directory)
MODEL_PATH = os.getenv('MODEL_PATH', '../ml-models/model.keras')
ENCODER_PATH = os.getenv('ENCODER_PATH', '../ml-models/label_encoder_382.pkl')
LABELS_PATH = os.getenv('LABELS_PATH', '../ml-models/labels_new.csv')

# Initialize inference engine
inference_engine = None

try:
    # Resolve absolute paths
    base_dir = os.path.dirname(os.path.abspath(__file__))
    model_path = os.path.join(base_dir, MODEL_PATH)
    encoder_path = os.path.join(base_dir, ENCODER_PATH)
    labels_path = os.path.join(base_dir, LABELS_PATH)
    
    print("\n" + "="*50)
    print("SignAura API Server - Initializing...")
    print("="*50)
    print(f"Model path: {model_path}")
    print(f"Encoder path: {encoder_path}")
    print(f"Labels path: {labels_path}")
    
    inference_engine = SignLanguageInference(model_path, encoder_path, labels_path)
    print("✅ Inference engine initialized successfully!")
    print("="*50 + "\n")
    
except Exception as e:
    print(f"\n❌ ERROR: Failed to initialize inference engine: {e}\n")
    inference_engine = None


@app.route('/')
def index():
    """Root endpoint - API info"""
    return jsonify({
        "name": "SignAura API",
        "version": "1.0.0",
        "description": "Sign Language Recognition API",
        "endpoints": {
            "/health": "GET - Health check",
            "/predict": "POST - Predict sign from image"
        }
    })


@app.route('/health', methods=['GET'])
def health_check():
    """Health check endpoint"""
    model_loaded = inference_engine is not None
    
    return jsonify({
        "status": "ok" if model_loaded else "error",
        "model_loaded": model_loaded,
        "timestamp": datetime.now().isoformat()
    }), 200 if model_loaded else 503


@app.route('/predict', methods=['POST'])
def predict():
    """
    Predict sign language gesture from image
    
    Request JSON:
    {
        "image": "base64_encoded_image_string"
    }
    
    Response JSON:
    {
        "success": true,
        "predictions": {
            "english": "Hello",
            "sinhala": "ආයුබෝවන්",
            "tamil": "வணக்கம்"
        },
        "confidence": 0.95,
        "timestamp": "2026-01-17T15:30:00"
    }
    """
    try:
        # Check if inference engine is loaded
        if inference_engine is None:
            return jsonify({
                "success": False,
                "error": "Model not loaded. Please check server logs."
            }), 503
        
        # Get request data
        data = request.get_json()
        
        if not data or 'image' not in data:
            return jsonify({
                "success": False,
                "error": "Missing 'image' field in request"
            }), 400
        
        # Get base64 image
        base64_image = data['image']
        
        # Predict
        result = inference_engine.predict_from_base64(base64_image)
        
        # Add timestamp
        result['timestamp'] = datetime.now().isoformat()
        
        if result['success']:
            return jsonify(result), 200
        else:
            return jsonify(result), 400
    
    except Exception as e:
        return jsonify({
            "success": False,
            "error": f"Server error: {str(e)}",
            "timestamp": datetime.now().isoformat()
        }), 500


@app.route('/test', methods=['GET'])
def test():
    """Test endpoint to verify API is working"""
    return jsonify({
        "message": "SignAura API is running!",
        "model_status": "loaded" if inference_engine else "not loaded",
        "timestamp": datetime.now().isoformat()
    })


# Error handlers
@app.errorhandler(404)
def not_found(error):
    return jsonify({
        "success": False,
        "error": "Endpoint not found"
    }), 404


@app.errorhandler(500)
def internal_error(error):
    return jsonify({
        "success": False,
        "error": "Internal server error"
    }), 500


if __name__ == '__main__':
    print("\n" + "="*50)
    print("🚀 Starting SignAura API Server...")
    print("="*50)
    print(f"Host: localhost")
    print(f"Port: {API_PORT}")
    print(f"Debug: {API_DEBUG}")
    print(f"Model loaded: {inference_engine is not None}")
    print("="*50)
    print(f"\n✓ API available at: http://localhost:{API_PORT}")
    print(f"✓ Health check: http://localhost:{API_PORT}/health")
    print(f"✓ Test endpoint: http://localhost:{API_PORT}/test\n")
    
    app.run(
        host='0.0.0.0',
        port=API_PORT,
        debug=API_DEBUG
    )
