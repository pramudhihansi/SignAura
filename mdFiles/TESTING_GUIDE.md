# 🚀 How to Test the Dashboard

### **Pre-requisites:**

✅ **1. Python packages installed:**
```cmd
cd api
venv\scripts\activate
REM If not installed yet:
pip install -r requirements.txt
```

✅ **2. Database created:**
- Open phpMyAdmin: http://localhost/phpmyadmin
- Database `signaura_db` exists
- Tables: `users`, `history`, `user_feedback`

✅ **3. XAMPP running:**
- Apache: ✅ Running (green)
- MySQL: ✅ Running (green)

---

### **Step-by-Step Testing:**

#### **Step 1: Start Flask API**

**Terminal 1:**
```cmd
cd D:\projects\SignAura
run-api.bat
```

**Expected output:**
```
==================================================
SignAura API Server - Initializing...
==================================================
Model path: D:\projects\SignAura\ml-models\model.keras
✓ Model loaded from ...
✓ Label encoder loaded (382 classes)
✅ Inference engine initialized successfully!
==================================================

🚀 Starting SignAura API Server...
 * Running on http://0.0.0.0:5000
```

**Verify:** Open browser → http://localhost:5000/health
Should show: `{"status":"ok","model_loaded":true}`

---

#### **Step 2: Start PHP Web Server**

**Terminal 2:**
```cmd
cd D:\projects\SignAura
run-web.bat
```

**Expected output:**
```
Starting SignAura PHP Web Server...
PHP 8.2.x Development Server (http://localhost:8000) started
```

---

#### **Step 3: Open Dashboard**

1. **Open browser:** http://localhost:8000
2. **Login** (or create account if needed)
   - Username: `testuser` (or create new)
   - Password: `test123`
3. **You should see:**
   - User Dashboard page
   - Webcam permission request → Click **"Allow"**
   - Video feed appears
   - User info shows: `Welcome, testuser 👋`
   - Status shows: `✅ AI Server Connected - Ready to recognize signs!`

---

#### **Step 4: Test Prediction Flow**

**4.1: Start Recognition**
1. Click **"▶️ Start Recognition"** button
2. Button should:
   - Disable "Start" button
   - Enable "Stop" button
3. Console should show: `✅ Recognition started - predicting every 500ms`

**4.2: Make Hand Gesture**
1. Show your hand to the camera (palm facing camera)
2. Make a clear gesture (e.g., thumbs up, peace sign, etc.)
3. **Wait 1-2 seconds**
4. **Expected:**
   - Prediction appears in output boxes:
     ```
     🇬🇧 English: Hello
     🇱🇰 Sinhala: ආයුබෝවන්
     🇮🇳 Tamil: வணக்கம்
     ```
   - Accuracy shows: `Accuracy: 87.3%` (example)

**4.3: Build Sentence**
1. Make another gesture (different one)
2. Prediction should **accumulate:**
   ```
   🇬🇧 English: Hello Thanks
   🇱🇰 Sinhala: ආයුබෝවන් ස්තූතියි
   🇮🇳 Tamil: வணக்கம் நன்றி
   ```

**4.4: Duplicate Filtering**
1. Hold the same gesture for 5 seconds
2. **Should NOT add multiple times**
3. Should stay: `Hello Thanks` (not `Hello Thanks Thanks Thanks`)

---

#### **Step 5: Test Controls**

**5.1: Stop Button**
1. Click **"⏸️ Stop Recognition"**
2. Predictions should pause
3. Make gestures → Nothing happens ✅

**5.2: Restart**
1. Click **"▶️ Start Recognition"** again
2. Predictions resume

**5.3: Clear Button**
1. Click **"🗑️ Clear Results"**
2. All outputs reset to `-`
3. Accuracy resets to `0%`
4. Sentence arrays cleared

---

#### **Step 6: Test Text-to-Speech**

1. Make a prediction (e.g., "Hello")
2. Click **"🔊 English"** → Should hear "Hello" in English
3. Click **"🔊 Sinhala"** → Should hear Sinhala pronunciation
4. Click **"🔊 Tamil"** → Should hear Tamil pronunciation

---

#### **Step 7: Test Error Handling**

**7.1: No Hand Detected**
1. Hide your hand from camera
2. Should show:
   ```
   🇬🇧 English: 👋 Show your hand to the camera
   🇱🇰 Sinhala: කැමරාවට ඔබේ අත පෙන්වන්න
   🇮🇳 Tamil: கேமராவில் உங்கள் கையைக் காட்டு
   ```

**7.2: Connection Lost**
1. Stop Flask API (press `Ctrl+C` in Terminal 1)
2. Dashboard should auto-detect and show:
   ```
   ❌ Lost connection to AI server!
   ```
3. Recognition should auto-stop

**7.3: Restart Flask**
1. Run `run-api.bat` again
2. Refresh dashboard page
3. Status should return to: `✅ AI Server Connected`

---

#### **Step 8: Test Database Integration**

1. Make 3 different gestures
2. Open phpMyAdmin: http://localhost/phpmyadmin
3. Navigate to: `signaura_db` → `history` table
4. Click "Browse"
5. **Should see:**
   - 3 rows with predictions
   - Columns: `user_id`, `predicted_sign_en`, `predicted_sign_si`, `predicted_sign_ta`, `confidence`, `created_at`
   - Timestamps match when you made gestures

---

#### **Step 9: Test Feedback Integration**

1. Make prediction: "Hello"
2. Click **"📝 Feedback & Review"** (navbar)
3. `feedback_review.html` should open
4. Should show last prediction from localStorage
5. Can rate and submit feedback

---

## 📊 Expected Performance

| Metric | Expected Value |
|--------|----------------|
| Page load time | < 2 seconds |
| First prediction | ~1 second after "Start" |
| Prediction frequency | Every 500ms |
| API response time | 100-200ms |
| Total cycle time | ~300-400ms |
| Accuracy (clear gestures) | 80-95% |
| Accuracy (unclear) | 40-60% (filtered out) |

---

## 🎓 How to Use

**For End Users:**
1. Open http://localhost:8000
2. Login
3. Allow camera permission
4. Click "▶️ Start Recognition"
5. Make hand gestures
6. Watch predictions appear
7. Click "⏸️ Stop" when done
8. Click "🗑️ Clear" to reset
9. Click TTS buttons to hear translations

---

## ✨ Final Notes

- **Keep both servers running** (Flask + PHP)
- **Don't refresh during recognition** (will reset sentences)
- **Clear results before starting new sentence**
- **Check console** if something doesn't work
- **Original file backed up** at `dashboard.php.backup`

---
