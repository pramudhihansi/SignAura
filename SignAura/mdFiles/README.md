# SignAura - AI-Powered Sign Language Translation System

Real-time sign language gesture recognition with multilingual output (English, Sinhala, Tamil).

## 🎯 Features

- ✅ Real-time sign language recognition (382 gestures)
- ✅ Multilingual output (English, Sinhala, Tamil)
- ✅ User authentication & role-based access
- ✅ Translation history tracking
- ✅ Feedback collection system
- ✅ Admin dashboard for analytics
- ✅ Text-to-speech functionality

## 🏗️ Architecture

```
Browser → PHP Web App (localhost:8000) → Flask API (localhost:5000) → ML Model → MySQL
```

## 📦 Tech Stack

**Backend:** Python, TensorFlow, Keras, MediaPipe, Flask  
**Frontend:** PHP, MySQL, Bootstrap 5, Vanilla JS  
**ML:** 381-class neural network with hand landmark detection

## 🚀 Quick Start (Windows 11)

### Prerequisites

- ✅ Python 3.11+ (you have 3.13.9)
- ✅ XAMPP (Apache, MySQL, PHP)
- ✅ Webcam

### Installation Steps

#### 1. Setup Python Virtual Environment

```cmd
cd api
python -m venv venv
venv\Scripts\activate
pip install -r requirements.txt
pip install flask flask-cors python-dotenv
```

#### 2. Setup Database

- Open XAMPP Control Panel
- Start **Apache** and **MySQL**
- Open browser: http://localhost/phpmyadmin
- Create database: `signaura_db`
- Import schema: `database\schema.sql`

**Using MySQL Command Line:**
```cmd
cd database
mysql -u root -p
CREATE DATABASE signaura_db;
USE signaura_db;
source schema.sql;
exit;
```

#### 3. Configure Environment

```cmd
REM Copy environment template
copy .env.example .env

REM Edit .env if needed (default values should work)
notepad .env
```

### Running the Application

#### Terminal 1: Python Flask API

```cmd
cd api
venv\Scripts\activate
python app.py
```

Expected output:
```
 * Running on http://localhost:5000
 * Model loaded successfully!
```

#### Terminal 2: PHP Web Server

```cmd
cd web\public
php -S localhost:8000
```

Expected output:
```
PHP 8.x.x Development Server (http://localhost:8000) started
```

#### Open Application

```cmd
start http://localhost:8000
```

Default login:
- Create account via signup page
- Role: Select "User" or "Admin"

## 📁 Project Structure

```
SignAura/
├── api/                        # Python ML Backend
│   ├── app.py                  # Flask API server
│   ├── inference.py            # ML inference logic
│   ├── requirements.txt        # Python dependencies
│   ├── scripts/                # Data processing utilities
│   │   ├── data_set.py        # Extract hand landmarks
│   │   ├── labele_encoder.py  # Encode labels
│   │   └── split_new_data.py  # Train/test split
│   └── notebooks/              # Jupyter notebooks
│
├── web/                        # PHP Frontend
│   ├── public/                 # Public pages
│   │   ├── index.php          # Landing page
│   │   ├── login.php          # Authentication
│   │   └── signup.php         # Registration
│   ├── api/                    # PHP API endpoints
│   │   ├── fetch_user.php
│   │   ├── fetch_history.php
│   │   └── save_prediction.php
│   ├── admin/                  # Admin panel
│   │   ├── dashboard.php
│   │   ├── users.php
│   │   └── history.php
│   └── user/                   # User dashboard
│       └── dashboard.php      # Main translator interface
│
├── ml-models/                  # ML Assets
│   ├── model.keras            # Trained model (407KB)
│   ├── label_encoder_382.pkl  # Label encoder (20KB)
│   ├── labels_new.csv         # Label mappings
│   └── datasets/              # Training data (69MB)
│
├── database/                   # Database files
    ├── schema.sql             # Complete database schema
    └── migrations/            # Database migrations
```

## 🧪 Testing the Setup

### Test 1: Flask API Health Check

```cmd
REM PowerShell
Invoke-WebRequest -Uri http://localhost:5000/health

REM Or use browser
start http://localhost:5000/health
```

Expected response:
```json
{"status": "ok", "model_loaded": true}
```

### Test 2: PHP Application

```cmd
start http://localhost:8000
```

Should show SignAura welcome page.

### Test 3: Database Connection

```cmd
start http://localhost/phpmyadmin
```

- Login with `root` (no password)
- Verify `signaura_db` exists
- Check tables: `users`, `history`, `user_feedback`

### Test 4: User Registration

1. Go to http://localhost:8000
2. Click "Sign Up"
3. Create account (Username: test, Password: test123)
4. Select role: User
5. Login and access dashboard

## 📖 How It Works

### Translation Flow

1. **Webcam Capture**: User's browser captures webcam frames (JavaScript)
2. **Frame Processing**: Frame sent to Flask API as base64 image
3. **Hand Detection**: MediaPipe extracts 21 hand landmarks (63 coordinates)
4. **Classification**: Keras model predicts sign gesture (381 classes)
5. **Multi-language Output**: Label decoded to English, Sinhala, Tamil
6. **Display**: Results shown in browser with confidence score
7. **Storage**: Prediction saved to MySQL database

### API Endpoints

#### Flask API (Python)

- `GET /health` - Server health check
- `POST /predict` - Single frame prediction

#### PHP API Endpoints

- `GET /api/fetch_user.php` - Get logged-in user info
- `GET /api/fetch_history.php` - Get user's translation history
- `POST /api/submit_feedback.php` - Submit feedback
- `POST /api/save_prediction.php` - Save prediction to database

## 🔧 Development

### Run Jupyter Notebooks

```cmd
cd api
venv\Scripts\activate
jupyter notebook
```

- `notebooks/SignAura_Training.ipynb` - Train new model
- `notebooks/liveCam.ipynb` - Test real-time inference
- `notebooks/Data_set.ipynb` - Explore dataset

### Update ML Model

1. Train new model in `SignAura_Training.ipynb`
2. Save as `model.keras`
3. Copy to `ml-models/` folder
4. Restart Flask API

### Add New Sign Gestures

1. Add images/videos to dataset
2. Run `api/scripts/data_set.py` to extract landmarks
3. Update `labels_new.csv` with new gesture names
4. Run `api/scripts/labele_encoder.py` to encode labels
5. Retrain model in Jupyter notebook

## 🚨 Common Issues

### Issue 1: Port Already in Use

**Error:** `Address already in use: 5000` or `8000`

**Solution:**
```cmd
REM Kill process using port
netstat -ano | findstr :5000
taskkill /PID <PID> /F

REM Or use different port
python app.py --port 5001
php -S localhost:8001
```

### Issue 2: Module Not Found

**Error:** `ModuleNotFoundError: No module named 'flask'`

**Solution:**
```cmd
REM Make sure venv is activated
cd api
venv\Scripts\activate
pip install -r requirements.txt
```

### Issue 3: Database Connection Failed

**Error:** `Database Connection Failed`

**Solution:**
- Start MySQL in XAMPP Control Panel
- Verify database exists: `signaura_db`
- Check `web/.env` for correct credentials

### Issue 4: Model File Not Found

**Error:** `FileNotFoundError: model.keras`

**Solution:**
- Verify model exists in `ml-models/model.keras`
- Check `api/.env` MODEL_PATH is correct
- Model should be relative path: `../ml-models/model.keras`

## 🛠️ Built With

- [TensorFlow 2.12](https://www.tensorflow.org/) - ML framework
- [MediaPipe 0.10](https://mediapipe.dev/) - Hand landmark detection
- [Flask 3.1](https://flask.palletsprojects.com/) - Python web framework
- [Bootstrap 5.3](https://getbootstrap.com/) - CSS framework
- [PHP 8.x](https://www.php.net/) - Server-side scripting
- [MySQL 8.x](https://www.mysql.com/) - Database

## 📝 License

This project was created for educational purposes.

## 🙏 Acknowledgments

- MediaPipe team for hand tracking technology
- TensorFlow team for ML framework
- Sign language dataset contributors
