# SignAura - AI-Powered Sign Language Translation System

**Status:** ✅ **FULLY INTEGRATED** - Web dashboard now operational with real-time predictions!

Real-time sign language gesture recognition with multilingual output (English, Sinhala, Tamil).

## 🎉 What's New (Latest Update)

**✅ Web Dashboard Integration Complete!**
- Real-time sign language recognition now works in the browser
- Sentence building (accumulates predictions like the original Jupyter notebook)
- Duplicate filtering (prevents repeated words)
- Manual start/stop controls
- Database integration (saves prediction history)
- Text-to-speech in 3 languages
- Comprehensive error handling

**Quick Start:** See [`mdFiles/QUICK_START.md`](mdFiles/QUICK_START.md) for 3-step setup!

---

## 🎯 Features

- ✅ **Real-time sign language recognition** (382 gestures) - **NOW WORKING IN BROWSER!**
- ✅ Multilingual output (English, Sinhala, Tamil)
- ✅ User authentication & role-based access
- ✅ Translation history tracking
- ✅ Feedback collection system
- ✅ Admin dashboard for analytics
- ✅ Text-to-speech functionality

## 🏗️ Architecture

```
Browser Webcam → JavaScript (captures frames)
       ↓
    Base64 encode
       ↓
Flask API (localhost:5000) → MediaPipe → Keras Model → Predictions
       ↓
JSON Response (EN/SI/TA)
       ↓
Dashboard Display → MySQL Database
```

## 📦 Tech Stack

**Backend:** Python, TensorFlow, Keras, MediaPipe, Flask  
**Frontend:** PHP, MySQL, Bootstrap 5, Vanilla JavaScript  
**ML:** 381-class neural network with hand landmark detection

---

## 🚀 Quick Start (Windows 11)

### Easy Method (Recommended)

**Step 1: Install Python packages**
```cmd
scripts\setup-python.bat
```
*(Wait 5-10 minutes for installation)*

**Step 2: Setup database**
- Open XAMPP → Start Apache + MySQL
- Open http://localhost/phpmyadmin
- Create database: `signaura_db`
- Import: `database\schema.sql`

**Step 3: Run application**
```cmd
Terminal 1: scripts\run-api.bat
Terminal 2: scripts\run-web.bat
Browser:    http://localhost:8000
```

**Step 4: Test sign recognition**
- Login → Allow camera → Click "▶️ Start Recognition" → Make gestures!

**📖 Detailed Guide:** See [`mdFiles/START_HERE.md`](mdFiles/START_HERE.md)

---

## 📁 Project Structure

```
SignAura/
├── scripts/                       # Helper scripts (batch files)
│   ├── run-api.bat               # Start Flask API
│   ├── run-web.bat               # Start PHP server
│   ├── setup-python.bat          # Install Python packages
│   └── check-setup.bat           # Verify installation
│
├── api/                           # Python ML Backend
│   ├── app.py                     # Flask REST API server
│   ├── inference.py               # ML inference engine
│   ├── requirements.txt           # Python dependencies
│   ├── scripts/                   # Data processing
│   └── notebooks/                 # Jupyter notebooks
│
├── web/                           # PHP Frontend
│   ├── db.php                     # Database connection
│   ├── .env.example               # Environment template
│   └── public/                    # Web pages
│       ├── index.php              # Landing page
│       ├── login.php              # Login page
│       ├── signup.php             # Registration
│       ├── user/                  # User dashboard
│       │   └── dashboard.php      # Real-time sign recognition
│       └── admin/                 # Admin panel
│           ├── dashboard.php      # Admin dashboard
│           ├── users.php          # User management
│           ├── delete_user.php    # Delete users (NEW!)
│           ├── history.php        # Translation history
│           └── feedback.php       # User feedback
│
├── ml-models/                     # ML Assets
│   ├── model.keras               # Trained model (407KB)
│   ├── label_encoder_382.pkl     # Label encoder
│   └── datasets/                 # Training data (69MB)
│
├── database/                      # Database
│   └── schema.sql                # Complete schema
│
└── mdFiles/                       # Documentation
    ├── QUICK_START.md            # 3-step quickstart
    ├── START_HERE.md             # Complete setup guide
    ├── TESTING_GUIDE.md          # Testing checklist
    ├── SETUP_COMPLETE.md         # What was done
    └── PYTHON_VERSIONS.md        # Python compatibility
```

---

## 🧪 Testing the Application

### 1. Start Servers
```cmd
scripts\run-api.bat  # Terminal 1
scripts\run-web.bat  # Terminal 2
```

### 2. Open Browser
```
http://localhost:8000
```

### 3. Test Recognition
- Login (or create account)
- Allow webcam permission
- Click **"▶️ Start Recognition"**
- Make hand gestures
- Watch predictions appear in 3 languages!

**Example Output:**
```
🇬🇧 English: Hello Thanks
🇱🇰 Sinhala: ආයුබෝවන් ස්තූතියි
🇮🇳 Tamil: வணக்கம் நன்றி
Accuracy: 87.3%
```

---

## 📖 How It Works

### Translation Flow

1. **Webcam Capture**: JavaScript captures frames from browser
2. **Convert to Base64**: Frame converted to JPEG base64 string
3. **Send to API**: POST request to `http://localhost:5000/predict`
4. **Hand Detection**: MediaPipe extracts 21 hand landmarks (63 coordinates)
5. **Classification**: Keras model predicts sign (381 classes)
6. **Decode**: Label encoder converts to English/Sinhala/Tamil
7. **Display**: Results shown in browser
8. **Save**: Prediction saved to MySQL `history` table

### API Endpoints

#### Flask API (Python)
- `GET /health` - Check server & model status
- `POST /predict` - Predict sign from base64 image

#### PHP API  
- `GET /api/fetch_user.php` - Get user info
- `GET /api/fetch_history.php` - Get prediction history
- `POST /api/save_prediction.php` - Save prediction to DB
- `POST /api/submit_feedback.php` - Submit user feedback

---

## 🔧 Development

### Run Jupyter Notebooks
```cmd
cd api
venv\Scripts\activate
jupyter notebook
```

- `notebooks/SignAura_Training.ipynb` - Train model
- `notebooks/liveCam.ipynb` - Test real-time (original)
- `notebooks/Data_set.ipynb` - Explore data

### Update ML Model
1. Train in `SignAura_Training.ipynb`
2. Save as `model.keras`
3. Copy to `ml-models/`
4. Restart Flask API

---

## 🚨 Troubleshooting

### "Cannot connect to AI server"
- Check Flask is running: `scripts\run-api.bat`
- Visit: http://localhost:5000/health
- Should see: `{"status":"ok","model_loaded":true}`

### No predictions appearing
- Open browser console (F12)
- Check for red errors
- Ensure both servers running

### Webcam not working
- Allow camera permission
- Close other apps (Zoom, Teams)
- Try Chrome browser

**Full troubleshooting:** See [`mdFiles/TESTING_GUIDE.md`](mdFiles/TESTING_GUIDE.md)

---

## 📚 Documentation

| Document | Description |
|----------|-------------|
| [**📚 INDEX.md**](mdFiles/INDEX.md) | **Master documentation index** - Navigation hub for all docs |
| [**QUICK_START.md**](mdFiles/QUICK_START.md) | **← Start here!** 3-step setup |
| [START_HERE.md](mdFiles/START_HERE.md) | Complete setup from scratch |
| [TESTING_GUIDE.md](mdFiles/TESTING_GUIDE.md) | Comprehensive testing checklist |
| [SETUP_COMPLETE.md](mdFiles/SETUP_COMPLETE.md) | Summary of integration work |
| [PYTHON_VERSIONS.md](mdFiles/PYTHON_VERSIONS.md) | Python 3.10/3.11 compatibility |
| [database/README.md](database/README.md) | Database schema & queries |
| [docs/AGENTS.md](docs/AGENTS.md) | AI agent coding guidelines |

---

## 🛠️ Built With

- [TensorFlow 2.12](https://www.tensorflow.org/) - ML framework
- [MediaPipe 0.10](https://mediapipe.dev/) - Hand landmark detection
- [Flask 3.1](https://flask.palletsprojects.com/) - Python API framework
- [Bootstrap 5.3](https://getbootstrap.com/) - CSS framework
- [PHP 8.x](https://www.php.net/) - Server-side scripting
- [MySQL 8.x](https://www.mysql.com/) - Database

---

## 📝 License

This project was created for educational purposes.

## 🙏 Acknowledgments

- MediaPipe team for hand tracking technology
- TensorFlow team for ML framework
- Sign language dataset contributors

---

**Ready to use?** → See [`mdFiles/QUICK_START.md`](mdFiles/QUICK_START.md) to get started in 3 steps! 🚀
