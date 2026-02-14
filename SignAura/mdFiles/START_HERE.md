# 🚀 SignAura - Complete Setup Guide (Windows 11)

---

## ✅ INTEGRATION COMPLETE!

**Good news!** The SignAura web dashboard is now **fully integrated** with the ML backend!

After following this setup guide, you'll have a working sign language recognition system running in your browser with:
- ✅ Real-time webcam recognition
- ✅ Predictions in 3 languages (English, Sinhala, Tamil)
- ✅ Sentence building with duplicate filtering
- ✅ Database storage of all predictions
- ✅ Text-to-speech for all languages

**Quick Links:**
- Want the fastest setup? → [QUICK_START.md](QUICK_START.md) (3 steps)
- Want to test the system? → [TESTING_GUIDE.md](TESTING_GUIDE.md) (10-step checklist)
- Want details on what changed? → [SETUP_COMPLETE.md](SETUP_COMPLETE.md)

---

## 📋 Prerequisites Checklist

Before starting, make sure you have installed:
- ✅ XAMPP (for Apache, MySQL, PHP)
- ✅ Python 3.10.x - 3.11.x
- ✅ Webcam (for testing sign language recognition)

---

## 🎯 Step-by-Step Setup Instructions

### **Step 1: Verify XAMPP is Running**

1. **Open XAMPP Control Panel:**
   - Press `Win` key
   - Type `XAMPP Control Panel`
   - Click on it (or find it at `C:\xampp\xampp-control.exe`)

2. **Start Services:**
   - Click **"Start"** button next to **Apache**
   - Click **"Start"** button next to **MySQL**
   - Both should turn **green** and show "Running"

3. **Test it works:**
   - Open browser: http://localhost
   - You should see XAMPP welcome page ✅

---

### **Step 2: Create Database**

#### **Using phpMyAdmin**

1. **Open phpMyAdmin:**
   - Open browser: http://localhost/phpmyadmin
   - You should see phpMyAdmin interface

2. **Create Database:**
   - Click **"New"** in the left sidebar
   - Database name: `signaura_db`
   - Collation: Select `utf8mb4_unicode_ci`
   - Click **"Create"**

3. **Import Schema:**
   - Click on `signaura_db` in the left sidebar
   - Click **"Import"** tab at the top
   - Click **"Choose File"**
   - Navigate to: `D:\projects\SignAura\database\schema.sql`
   - Click **"Import"** at the bottom
   - You should see: "Import has been successfully finished" ✅

4. **Verify Tables Created:**
   - Click `signaura_db` in left sidebar
   - You should see 3 tables:
     - `users`
     - `history`
     - `user_feedback`


---

### **Step 3: Install Python Packages**

#### **Understanding .bat Files**

`.bat` files are Windows batch scripts - they're like shortcuts that run multiple commands automatically.

#### **Run the Setup**

1. **Navigate to project folder:**
   ```cmd
   Win + E  (Open File Explorer)
   Navigate to D:\projects\SignAura
   ```

2. **Double-click `scripts/setup-python.bat`**
   
   A black window will open showing:
   ```
   ╔════════════════════════════════════════════════════════════╗
   ║     SignAura Setup - Using Python 3.11 for TensorFlow     ║
   ╚════════════════════════════════════════════════════════════╝
   
   [1/5] Checking Python 3.10/3.11 installation...
   Python 3.10.x/3.11.x
   ✓ Python 3.10.x/3.11 found
   
   [2/5] Navigating to api directory...
   ✓ In api directory
   
   [3/5] Creating virtual environment with Python 3.11...
   ✓ Virtual environment created
   
   [4/5] Activating virtual environment...
   ✓ Virtual environment activated
   
   [5/5] Installing Python packages (this may take 5-10 minutes)...
   Installing packages from requirements.txt...
   ```

3. **Wait for installation** (5-10 minutes)
   - You'll see lots of text scrolling
   - Downloading packages from the internet
   - Installing TensorFlow, OpenCV, MediaPipe, etc.

4. **When done, you'll see:**
   ```
   ════════════════════════════════════════════════════════════
   ✅ Setup Complete!
   ════════════════════════════════════════════════════════════
   
   Verify installation:
   Python 3.11.x
   
   Press any key to exit
   ```

5. **Press any key** to close the window

---

### **Step 4: Start the Application**

You need **TWO terminals** running simultaneously:
- Terminal 1: Python Flask API (port 5000)
- Terminal 2: PHP Web Server (port 8000)

#### **Terminal 1: Start Flask API**

1. **Open File Explorer:**
   - Press `Win + E`
   - Navigate to `D:\projects\SignAura`

2. **Double-click `scripts/run-api.bat`**

3. **You should see:**
   ```
   Starting SignAura Flask API Server...
   
   Activating virtual environment...
   Python 3.11.x
   
   Starting Flask API on http://localhost:5000
   
   ==================================================
   SignAura API Server - Initializing...
   ==================================================
   Model path: D:\projects\SignAura\ml-models\model.keras
   ✓ Model loaded from ...
   ✓ Label encoder loaded (382 classes)
   ✅ Inference engine initialized successfully!
   ==================================================
   
   🚀 Starting SignAura API Server...
   ==================================================
   Host: localhost
   Port: 5000
   Debug: True
   Model loaded: True
   ==================================================
   
   ✓ API available at: http://localhost:5000
   ✓ Health check: http://localhost:5000/health
   
    * Running on http://0.0.0.0:5000
   ```

4. **Leave this window open!** Don't close it.

5. **Test it works:**
   - Open browser: http://localhost:5000/health
   - Should show: `{"status":"ok","model_loaded":true}`

#### **Terminal 2: Start PHP Web Server**

1. **Open File Explorer again:**
   - Press `Win + E`
   - Navigate to `D:\projects\SignAura`

2. **Double-click `scripts/run-web.bat`**

3. **You should see:**
   ```
   Starting SignAura PHP Web Server...
   
   Starting PHP server on http://localhost:8000
   
   PHP 8.2.x Development Server (http://localhost:8000) started
   ```

4. **Leave this window open too!** Keep both terminals running.

---

### **Step 5: Open the Application**

1. **Open Browser:**
   - Chrome, Firefox, or Edge
   - Go to: http://localhost:8000

2. **You should see:**
   - SignAura welcome page with purple/pink gradient
   - "Login" and "Sign Up" buttons

3. **What you can do now:**
   - ✅ Create account and login
   - ✅ Access dashboard with webcam feed
   - ✅ **Use real-time sign language recognition** (fully working!)
   - ✅ See predictions in 3 languages
   - ✅ Build sentences from gestures
   - ✅ Save predictions to database

---

### **Step 6: Create Your Account & Start Using**

1. **Click "Sign Up"**

2. **Fill in the form:**
   - Username: `user` (or anything you want)
   - Email: `user@user.com`
   - Password: `user123`
   - Role: Select **"User"** (or "Admin" if you want admin access)

3. **Click "Sign Up"**

4. **Login:**
   - Username: `user`
   - Password: `user123`
   - Click "Login"

5. **You should see:**
   - User Dashboard
   - Webcam video feed (live!)
   - "▶️ Start Recognition" button
   - Translation output boxes (English, Sinhala, Tamil)
   - Text-to-speech buttons (🔊)
   - API status indicator (should be green)

6. **Test sign recognition:**
   - Click "▶️ Start Recognition"
   - Show a hand gesture to the webcam
   - Wait 1-2 seconds
   - See prediction appear in all 3 languages!
   - Continue making gestures to build sentences

---

## 📁 Quick Reference: All the .bat Files

I created these helper scripts for you:

| File | What it does | When to use |
|------|-------------|-------------|
| `scripts/setup-python.bat` | Install Python packages with Python 3.11 | **ONCE** - First time setup |
| `scripts/run-api.bat` | Start Flask API server | **EVERY TIME** - Start the API |
| `scripts/run-web.bat` | Start PHP web server | **EVERY TIME** - Start the web app |
| `scripts/check-setup.bat` | Verify everything is installed correctly | Anytime - Troubleshooting |

---

## 🔄 Daily Usage Workflow

After initial setup, here's what you do each time:

**Step 1:** Start XAMPP
- Open XAMPP Control Panel
- Start Apache + MySQL

**Step 2:** Start API
```cmd
Double-click: scripts/run-api.bat
Keep window open
```

**Step 3:** Start Web Server
```cmd
Double-click: scripts/run-web.bat
Keep window open
```

**Step 4:** Open Browser
```
http://localhost:8000
```

**Step 5:** When done, stop everything
- Close both terminal windows (API and Web)
- Stop Apache + MySQL in XAMPP

---

## 🚨 Troubleshooting

### **Problem: "Port 5000 already in use"**

**Kill the process:**
```cmd
netstat -ano | findstr :5000
taskkill /PID <number> /F
```

Or just restart your computer.

### **Problem: "Database connection failed"**

**Check:**
1. Is MySQL running in XAMPP? (should be green)
2. Does database exist?
   - Open: http://localhost/phpmyadmin
   - Look for `signaura_db` on left side
3. Run `database\schema.sql` again if needed

### **Problem: Model file not found**

**Verify files exist:**
```cmd
cd D:\projects\SignAura\ml-models
dir
```

Should show:
- `model.keras` (407 KB)
- `label_encoder_382.pkl` (20 KB)
- `labels_new.csv` (20 KB)

If missing, they're still in the `back/` folder - let me know!

### **Problem: Webcam not working**

1. Make sure no other app is using the webcam (Zoom, Teams, etc.)
2. Allow camera access when browser asks
3. Try a different browser (Chrome works best)

---

## 🎓 Understanding the Structure

```
D:\projects\SignAura\
├── scripts/               ← Helper scripts (batch files)
│   ├── run-api.bat       ← Double-click to start Flask
│   ├── run-web.bat       ← Double-click to start PHP
│   ├── setup-python.bat  ← Run once to install packages
│   └── check-setup.bat   ← Check if everything is installed
│
├── api/                   ← Python ML Backend
│   ├── venv/             ← Created by setup-python.bat
│   ├── app.py            ← Flask server (port 5000)
│   └── inference.py      ← ML prediction logic
│
├── web/                   ← PHP Frontend
│   ├── db.php            ← Database connection
│   ├── .env.example      ← Environment template (copy to .env)
│   └── public/           ← Web pages (port 8000)
│       ├── index.php     ← Landing page
│       ├── login.php     ← Login page
│       ├── signup.php    ← Registration
│       ├── user/         ← User dashboard
│       │   └── dashboard.php
│       └── admin/        ← Admin panel
│           ├── dashboard.php
│           ├── users.php
│           └── delete_user.php
│
├── ml-models/            ← AI Model files
│   ├── model.keras       ← Trained neural network
│   └── label_encoder_382.pkl
│
└── database/             ← Database setup
    └── schema.sql        ← Database structure
```