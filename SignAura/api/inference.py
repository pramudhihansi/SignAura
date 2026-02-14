"""
Inference module for Sign Language Recognition
Handles ML model loading and prediction logic
"""

import os
import pickle
import cv2
import numpy as np
import mediapipe as mp
from tensorflow import keras


class SignLanguageInference:
    def __init__(self, model_path, encoder_path, labels_path):
        """Initialize the inference engine with model paths"""
        self.model_path = model_path
        self.encoder_path = encoder_path
        self.labels_path = labels_path
        
        # Initialize MediaPipe
        self.mp_hands = mp.solutions.hands
        self.hands = self.mp_hands.Hands(
            static_image_mode=True,
            max_num_hands=1,
            min_detection_confidence=0.6
        )
        
        # Load model and encoder
        self.model = None
        self.label_encoder = None
        self.load_model()
    
    def load_model(self):
        """Load the Keras model and label encoder"""
        try:
            # Load Keras model
            if not os.path.exists(self.model_path):
                raise FileNotFoundError(f"Model not found at {self.model_path}")
            
            self.model = keras.models.load_model(self.model_path)
            print(f"✓ Model loaded from {self.model_path}")
            
            # Load label encoder
            if not os.path.exists(self.encoder_path):
                raise FileNotFoundError(f"Encoder not found at {self.encoder_path}")
            
            with open(self.encoder_path, 'rb') as f:
                self.label_encoder = pickle.load(f)
            print(f"✓ Label encoder loaded ({len(self.label_encoder.classes_)} classes)")
            
            return True
            
        except Exception as e:
            print(f"❌ Error loading model: {e}")
            return False
    
    def extract_landmarks(self, image):
        """Extract hand landmarks from image using MediaPipe"""
        try:
            # Convert BGR to RGB (OpenCV uses BGR)
            image_rgb = cv2.cvtColor(image, cv2.COLOR_BGR2RGB)
            
            # Process with MediaPipe
            results = self.hands.process(image_rgb)
            
            if not results.multi_hand_landmarks:
                return None
            
            # Extract landmarks (21 points × 3 coordinates = 63 features)
            landmarks = results.multi_hand_landmarks[0]
            landmark_list = []
            
            for lm in landmarks.landmark:
                landmark_list.extend([lm.x, lm.y, lm.z])
            
            return landmark_list
            
        except Exception as e:
            print(f"❌ Error extracting landmarks: {e}")
            return None
    
    def predict(self, image):
        """
        Predict sign language gesture from image
        
        Args:
            image: numpy array (OpenCV image)
            
        Returns:
            dict: {
                'success': bool,
                'predictions': {
                    'english': str,
                    'sinhala': str,
                    'tamil': str
                },
                'confidence': float,
                'error': str (if failed)
            }
        """
        try:
            # Extract landmarks
            landmarks = self.extract_landmarks(image)
            
            if landmarks is None:
                return {
                    'success': False,
                    'error': 'No hand detected in image'
                }
            
            # Reshape for model input (1, 63)
            features = np.array([landmarks])
            
            # Predict
            prediction = self.model.predict(features, verbose=0)
            class_index = np.argmax(prediction[0])
            confidence = float(prediction[0][class_index])
            
            # Decode label
            combined_label = self.label_encoder.inverse_transform([class_index])[0]
            
            # Split into languages (format: "English|Sinhala|Tamil")
            labels = combined_label.split('|')
            
            if len(labels) != 3:
                return {
                    'success': False,
                    'error': 'Invalid label format'
                }
            
            return {
                'success': True,
                'predictions': {
                    'english': labels[0].strip(),
                    'sinhala': labels[1].strip(),
                    'tamil': labels[2].strip()
                },
                'confidence': confidence
            }
            
        except Exception as e:
            return {
                'success': False,
                'error': str(e)
            }
    
    def predict_from_base64(self, base64_string):
        """
        Predict from base64 encoded image
        
        Args:
            base64_string: str (base64 encoded image)
            
        Returns:
            dict: prediction result
        """
        try:
            # Remove data URL prefix if present
            if ',' in base64_string:
                base64_string = base64_string.split(',')[1]
            
            # Decode base64 to image
            import base64
            image_bytes = base64.b64decode(base64_string)
            image_array = np.frombuffer(image_bytes, dtype=np.uint8)
            image = cv2.imdecode(image_array, cv2.IMREAD_COLOR)
            
            if image is None:
                return {
                    'success': False,
                    'error': 'Failed to decode image'
                }
            
            # Predict
            return self.predict(image)
            
        except Exception as e:
            return {
                'success': False,
                'error': f'Base64 decode error: {str(e)}'
            }
