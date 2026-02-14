<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignAura | User Dashboard</title>

    <link rel="icon" type="image/jpeg" href="../assets/images/logo.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Poppins', sans-serif; }

        body {
            background: linear-gradient(135deg, #8B5CF6, #EC4899, #F97316);
            background-size: 400% 400%;
            animation: gradientMove 15s ease infinite;
            min-height: 100vh;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .navbar {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 24px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-logout {
            padding: 10px 25px;
            border-radius: 12px;
            font-weight: 600;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
        }

        .dashboard-card {
            background: rgba(255,255,255,0.25);
            backdrop-filter: blur(15px);
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
            margin-top: 40px;
        }

        /* 🔹 Camera Container */
        .video-container {
            background: black;
            border-radius: 25px;
            overflow: hidden;
            margin-bottom: 20px;
            width: 100%;
            height: 650px;
            position: relative; /* For overlays */
            border: 5px solid #6b7280; /* Default border */
            transition: border-color 0.3s ease;
        }

        /* Video Border States */
        .border-idle { border-color: #6b7280; }
        .border-detected { border-color: #3b82f6; } /* Blue */
        .border-countdown { 
            border-color: #eab308; /* Yellow */
            animation: pulse-yellow 1s infinite;
        }
        .border-processing { 
            border-color: #f97316; /* Orange */
            animation: pulse-orange 1s infinite;
        }
        .border-captured { 
            border-color: #22c55e; /* Green */
            box-shadow: 0 0 50px #22c55e;
            transition: all 0.1s;
        }

        @keyframes pulse-yellow {
            0% { box-shadow: 0 0 0 0 rgba(234, 179, 8, 0.7); }
            70% { box-shadow: 0 0 0 15px rgba(234, 179, 8, 0); }
            100% { box-shadow: 0 0 0 0 rgba(234, 179, 8, 0); }
        }
        @keyframes pulse-orange {
            0% { box-shadow: 0 0 0 0 rgba(249, 115, 22, 0.7); }
            70% { box-shadow: 0 0 0 15px rgba(249, 115, 22, 0); }
            100% { box-shadow: 0 0 0 0 rgba(249, 115, 22, 0); }
        }

        video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scaleX(-1); /* Mirror effect */
        }

        /* Overlays */
        .countdown-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 150px;
            font-weight: 800;
            color: white;
            text-shadow: 0 0 20px rgba(0,0,0,0.8);
            background: rgba(0,0,0,0.4);
            border-radius: 50%;
            width: 250px;
            height: 250px;
            display: none; /* Hidden by default */
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        .spinner-overlay {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            border: 5px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
            display: none;
            z-index: 10;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Status Bar */
        .status-bar {
            background: rgba(255, 255, 255, 0.9);
            padding: 15px 25px;
            border-radius: 15px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .status-text { font-size: 1.1em; color: #374151; }
        .hand-status { font-size: 0.9em; color: #6b7280; }

        .output-box {
            background: rgba(255,255,255,0.85);
            padding: 25px;
            border-radius: 20px;
        }

        .output-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }

        .accuracy-box {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 12px;
            border-radius: 12px;
            text-align: center;
            margin-top: 15px;
            font-weight: 700;
        }

        .voice-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .btn-voice {
            padding: 12px 20px;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            border: none;
        }

        .english { background: #2563eb; }
        .sinhala { background: #059669; }
        .tamil { background: #d97706; }
        
        /* Control buttons */
        .btn-lg {
            padding: 15px 30px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 15px;
        }
        
        #api-status {
            padding: 15px;
            border-radius: 12px;
            font-weight: 600;
        }

        .sentence-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <span class="navbar-brand">✨ SignAura</span>
        <div class="d-flex gap-2">
            <a href="History_feedback.php" class="btn btn-outline-primary fw-semibold">
                📚 History & Feedback
            </a>
            <a href="../logout.php" class="btn btn-logout">🚪 Logout</a>
        </div>
    </div>
</nav>

<!-- DASHBOARD -->
<div class="container">
    <div class="dashboard-card">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                Welcome, <span id="username">Loading...</span> 👋
            </h2>
            <div id="user-info" class="text-muted">Loading user info...</div>
        </div>

        <h4>🎥 Live Sign Language Translation</h4>
        
        <!-- Video Container with Overlays -->
        <div class="video-container" id="video-container">
            <video id="video" autoplay></video>
            
            <!-- Countdown Overlay -->
            <div id="countdown-overlay" class="countdown-overlay">3</div>
            
            <!-- Loading Spinner -->
            <div id="loading-spinner" class="spinner-overlay"></div>
        </div>

        <!-- New Status Bar -->
        <div class="status-bar">
            <div id="status-text" class="status-text">🎯 Status: Waiting to start...</div>
            <div id="hand-status" class="hand-status">👋 No hand detected</div>
        </div>

        <div class="output-box">
            <div class="sentence-info">
                <span class="badge bg-secondary fs-6">Draft Sentence</span>
                <span id="sign-count" class="text-muted">0 signs</span>
            </div>

            <div class="output-row"><b>🇬🇧 English:</b> <span id="output-en">-</span></div>
            <div class="output-row"><b>🇱🇰 Sinhala:</b> <span id="output-si">-</span></div>
            <div class="output-row"><b>🇮🇳 Tamil:</b> <span id="output-ta">-</span></div>

            <div class="accuracy-box">
                Last Accuracy: <span id="accuracy">0%</span>
            </div>
        </div>

        <div class="voice-buttons">
            <button id="speak-en" class="btn-voice english">🔊 English</button>
            <button id="speak-si" class="btn-voice sinhala">🔊 Sinhala</button>
            <button id="speak-ta" class="btn-voice tamil">🔊 Tamil</button>
        </div>

        <!-- Control Buttons -->
        <div class="mt-4 row g-2">
            <!-- Row 1: Recognition Controls -->
            <div class="col-md-4">
                <button id="btn-start" class="btn btn-success btn-lg w-100">▶️ Start</button>
            </div>
            <div class="col-md-4">
                <button id="btn-stop" class="btn btn-danger btn-lg w-100" disabled>⏸️ Stop</button>
            </div>
            <div class="col-md-4">
                <button id="btn-clear" class="btn btn-warning btn-lg w-100">🗑️ Clear</button>
            </div>
            
            <!-- Row 2: Sentence Management -->
            <div class="col-md-6 mt-3">
                <button id="btn-finish" class="btn btn-primary btn-lg w-100" disabled>
                    ✅ Finish Sentence
                </button>
            </div>
            <div class="col-md-6 mt-3">
                <button id="btn-new-sentence" class="btn btn-secondary btn-lg w-100" disabled>
                    📝 New Sentence
                </button>
            </div>
            
            <!-- Row 3: Navigation -->
            <div class="col-12 mt-3">
                <a href="History_feedback.php" class="btn btn-info btn-lg w-100 text-white fw-bold">
                    📚 View History & Feedback
                </a>
            </div>
        </div>

        <!-- API Status Indicator -->
        <div id="api-status" class="alert alert-info mt-3">
            🔌 Checking AI server connection...
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@4.9.0/dist/tf.min.js"></script>

<script>
// ========================================
// SIGN LANGUAGE RECOGNITION SYSTEM
// ========================================

// Configuration
const API_URL = 'http://localhost:5000/predict';
const HAND_CHECK_INTERVAL = 600;      // Check for hand every 600ms (Reduced for performance)
const COUNTDOWN_DURATION = 3;         // 3 seconds
const CONFIDENCE_THRESHOLD = 0.6;     // 60% confidence
const CAPTURE_FLASH_TIME = 500;       // ms

// State Constants
const STATE = {
    IDLE: 'IDLE',
    HAND_DETECTED: 'HAND_DETECTED',
    COUNTDOWN: 'COUNTDOWN',
    PROCESSING: 'PROCESSING',
    CAPTURED: 'CAPTURED',
    STOPPED: 'STOPPED'
};

// Global State
let currentState = STATE.STOPPED;
let predictionLoop = null;
let countdownTimer = null;
let countdownValue = 3;
let lastPrediction = ''; // To prevent duplicates (optional, based on logic)

// Sentence Buffer
let currentSentence = {
    en: [],
    si: [],
    ta: [],
    predictionIds: [], // IDs from history table
    confidences: []
};

// ========================================
// 1. INITIALIZATION & SETUP
// ========================================

// Fetch User Info
fetch("../api/fetch_user.php")
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('username').innerText = data.user.username;
            document.getElementById('user-info').innerHTML = `📧 ${data.user.email} | 👤 ${data.user.role}`;
        }
    })
    .catch(err => console.error('Failed to fetch user info:', err));

// Setup Webcam
const video = document.getElementById('video');
navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => {
        video.srcObject = stream;
        console.log('✓ Webcam connected');
    })
    .catch(err => {
        console.error("Webcam access error:", err);
        alert('❌ Cannot access webcam. Please allow camera permission.');
    });

// Check API Health
async function checkAPIConnection() {
    try {
        const response = await fetch('http://localhost:5000/health');
        const data = await response.json();
        
        const statusDiv = document.getElementById('api-status');
        if (data.status === 'ok' && data.model_loaded) {
            statusDiv.className = 'alert alert-success';
            statusDiv.innerHTML = '✅ AI Server Connected - Ready to recognize signs!';
        } else {
            statusDiv.className = 'alert alert-danger';
            statusDiv.innerHTML = '❌ AI Model not loaded on server';
        }
    } catch (error) {
        const statusDiv = document.getElementById('api-status');
        statusDiv.className = 'alert alert-danger';
        statusDiv.innerHTML = '❌ Cannot connect to AI server. Make sure Flask is running on port 5000.';
    }
}
checkAPIConnection();

// ========================================
// 2. CORE RECOGNITION LOGIC
// ========================================

function startRecognition() {
    if (currentState !== STATE.STOPPED) return;
    
    currentState = STATE.IDLE;
    updateUIForState(STATE.IDLE);
    
    // Disable Start, Enable Stop
    document.getElementById('btn-start').disabled = true;
    document.getElementById('btn-stop').disabled = false;
    
    // Start Polling Loop
    predictionLoop = setInterval(runRecognitionLoop, HAND_CHECK_INTERVAL);
    console.log("✅ Recognition Started");
}

function stopRecognition() {
    clearInterval(predictionLoop);
    clearTimeout(countdownTimer);
    
    currentState = STATE.STOPPED;
    updateUIForState(STATE.STOPPED);
    
    // Reset buttons
    document.getElementById('btn-start').disabled = false;
    document.getElementById('btn-stop').disabled = true;
    
    // Hide overlays
    document.getElementById('countdown-overlay').style.display = 'none';
    document.getElementById('loading-spinner').style.display = 'none';
    
    console.log("⏸️ Recognition Stopped");
}

async function runRecognitionLoop() {
    // Only proceed if video is playing
    if (!video.srcObject || video.readyState !== 4) return;

    // Capture Frame
    const imageData = captureFrame();

    // Decision Logic based on State
    if (currentState === STATE.IDLE || currentState === STATE.HAND_DETECTED) {
        // Quick Check / Prediction
        await checkHandAndPredict(imageData);
    }
}

function captureFrame() {
    const canvas = document.createElement('canvas');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0);
    return canvas.toDataURL('image/jpeg', 0.8);
}

// ========================================
// 3. STATE MACHINE & LOGIC
// ========================================

async function checkHandAndPredict(imageData) {
    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ image: imageData })
        });
        const result = await response.json();

        if (result.success && result.confidence >= CONFIDENCE_THRESHOLD) {
            // Hand Detected
            handleHandDetected(result);
        } else {
            // No Hand or Low Confidence
            handleNoHand();
        }
    } catch (error) {
        console.error("API Error:", error);
    }
}

function handleHandDetected(result) {
    if (currentState === STATE.IDLE) {
        // Hand just appeared -> Start Countdown
        currentState = STATE.COUNTDOWN;
        updateUIForState(STATE.COUNTDOWN);
        startCountdown(result); // Pass result to confirm validity
    } else if (currentState === STATE.HAND_DETECTED) {
        // Already stable, waiting for next cycle? 
        // Logic handled in countdown function usually
    }
}

function handleNoHand() {
    if (currentState === STATE.COUNTDOWN) {
        // Hand lost during countdown -> Cancel
        cancelCountdown();
    } else if (currentState === STATE.IDLE) {
        updateUIForState(STATE.IDLE);
    }
}

function startCountdown(initialResult) {
    countdownValue = COUNTDOWN_DURATION;
    updateCountdownUI(countdownValue);
    document.getElementById('countdown-overlay').style.display = 'flex';

    // Countdown Timer (1s intervals)
    countdownTimer = setInterval(async () => {
        countdownValue--;
        if (countdownValue > 0) {
            updateCountdownUI(countdownValue);
        } else {
            // Countdown Finished -> CAPTURE
            clearInterval(countdownTimer);
            await processCapture();
        }
    }, 1000);
}

function cancelCountdown() {
    clearInterval(countdownTimer);
    document.getElementById('countdown-overlay').style.display = 'none';
    currentState = STATE.IDLE;
    updateUIForState(STATE.IDLE);
    console.log("Countdown Cancelled (Hand Lost)");
}

function updateCountdownUI(val) {
    document.getElementById('countdown-overlay').innerText = val;
}

async function processCapture() {
    currentState = STATE.PROCESSING;
    updateUIForState(STATE.PROCESSING);
    document.getElementById('countdown-overlay').style.display = 'none';
    document.getElementById('loading-spinner').style.display = 'block';

    // Capture the ACTUAL frame now (or reuse last good one? Live is better)
    const imageData = captureFrame();

    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ image: imageData })
        });
        const result = await response.json();

        document.getElementById('loading-spinner').style.display = 'none';

        if (result.success && result.confidence >= CONFIDENCE_THRESHOLD) {
            // Success!
            currentState = STATE.CAPTURED;
            updateUIForState(STATE.CAPTURED);
            
            // Add to Sentence Buffer
            addToSentence(result);

            // Brief Flash then back to search
            setTimeout(() => {
                currentState = STATE.IDLE; // Reset to look for next sign
                updateUIForState(STATE.IDLE); // Clear green border
            }, CAPTURE_FLASH_TIME);

        } else {
            // Failed at the last second
            console.log("Capture failed: Low confidence or no hand");
            currentState = STATE.IDLE;
            updateUIForState(STATE.IDLE);
        }

    } catch (error) {
        console.error("Capture Error:", error);
        document.getElementById('loading-spinner').style.display = 'none';
        currentState = STATE.IDLE;
    }
}

// ========================================
// 4. SENTENCE MANAGEMENT
// ========================================

function addToSentence(result) {
    const en = result.predictions.english;
    const si = result.predictions.sinhala;
    const ta = result.predictions.tamil;
    
    // Update Buffers
    currentSentence.en.push(en);
    currentSentence.si.push(si);
    currentSentence.ta.push(ta);
    currentSentence.confidences.push(result.confidence);

    // Update UI
    document.getElementById('output-en').innerText = currentSentence.en.join(' ');
    document.getElementById('output-si').innerText = currentSentence.si.join(' ');
    document.getElementById('output-ta').innerText = currentSentence.ta.join(' ');
    document.getElementById('accuracy').innerText = (result.confidence * 100).toFixed(1) + '%';
    document.getElementById('sign-count').innerText = `${currentSentence.en.length} signs`;

    // Save individual prediction to history (as before)
    savePredictionToDatabase(result);

    // Enable Finish Button
    document.getElementById('btn-finish').disabled = false;
    document.getElementById('btn-new-sentence').disabled = true;
}

async function savePredictionToDatabase(result) {
    try {
        const response = await fetch('../api/save_prediction.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(result)
        });
        const data = await response.json();
        if (data.success) {
            // Store ID to link later
            currentSentence.predictionIds.push(data.prediction_id);
        }
    } catch (error) {
        console.error('DB Error:', error);
    }
}

async function finishSentence() {
    if (currentSentence.en.length === 0) return;

    // Prepare data
    const payload = {
        sentence_en: currentSentence.en.join(' '),
        sentence_si: currentSentence.si.join(' '),
        sentence_ta: currentSentence.ta.join(' '),
        sign_count: currentSentence.en.length,
        avg_confidence: currentSentence.confidences.reduce((a,b)=>a+b,0) / currentSentence.confidences.length,
        prediction_ids: currentSentence.predictionIds
    };

    try {
        const response = await fetch('../api/save_sentence.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });
        const data = await response.json();
        
        if (data.success) {
            // UI Feedback
            alert("🎉 Sentence saved successfully!");
            document.getElementById('btn-finish').disabled = true;
            document.getElementById('btn-new-sentence').disabled = false;
        } else {
            alert("❌ Failed to save sentence");
        }
    } catch (e) {
        console.error(e);
        alert("❌ Error saving sentence");
    }
}

function startNewSentence() {
    // Clear Buffers
    currentSentence = { en: [], si: [], ta: [], predictionIds: [], confidences: [] };
    
    // Clear UI
    document.getElementById('output-en').innerText = '-';
    document.getElementById('output-si').innerText = '-';
    document.getElementById('output-ta').innerText = '-';
    document.getElementById('sign-count').innerText = '0 signs';
    
    // Reset Buttons
    document.getElementById('btn-finish').disabled = true;
    document.getElementById('btn-new-sentence').disabled = true;
}

// ========================================
// 5. VISUAL FEEDBACK & HELPERS
// ========================================

function updateUIForState(state) {
    const container = document.getElementById('video-container');
    const statusText = document.getElementById('status-text');
    const handStatus = document.getElementById('hand-status');

    // Reset Border Classes
    container.classList.remove('border-idle', 'border-detected', 'border-countdown', 'border-processing', 'border-captured');

    switch (state) {
        case STATE.STOPPED:
            container.classList.add('border-idle');
            statusText.innerText = "🎯 Status: Stopped";
            handStatus.innerText = "❌ Recognition inactive";
            break;
        case STATE.IDLE:
            container.classList.add('border-idle');
            statusText.innerText = "🎯 Status: Waiting for hand...";
            handStatus.innerText = "👋 No hand detected";
            break;
        case STATE.COUNTDOWN:
            container.classList.add('border-countdown');
            statusText.innerText = "⏳ Status: Hold steady!";
            handStatus.innerText = "👋 Hand Detected - Capturing...";
            break;
        case STATE.PROCESSING:
            container.classList.add('border-processing');
            statusText.innerText = "🔄 Status: Processing...";
            break;
        case STATE.CAPTURED:
            container.classList.add('border-captured');
            statusText.innerText = "✅ Status: Captured!";
            break;
    }
}

// Clear Logic (Hard Reset)
function clearAll() {
    startNewSentence();
}

// Text to Speech
function speak(text, lang) {
    if (text && text !== '-') {
        let u = new SpeechSynthesisUtterance(text);
        u.lang = lang;
        speechSynthesis.speak(u);
    }
}
document.getElementById('speak-en').onclick = () => speak(document.getElementById('output-en').innerText, 'en-US');
document.getElementById('speak-si').onclick = () => speak(document.getElementById('output-si').innerText, 'si-LK');
document.getElementById('speak-ta').onclick = () => speak(document.getElementById('output-ta').innerText, 'ta-IN');

// Event Listeners
document.getElementById('btn-start').onclick = startRecognition;
document.getElementById('btn-stop').onclick = stopRecognition;
document.getElementById('btn-clear').onclick = clearAll;
document.getElementById('btn-finish').onclick = finishSentence;
document.getElementById('btn-new-sentence').onclick = startNewSentence;

// Cleanup
window.addEventListener('beforeunload', () => stopRecognition());

</script>

</body>
</html>
