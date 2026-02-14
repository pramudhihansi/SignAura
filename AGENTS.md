# SignAura - Agent Guidelines

This document provides comprehensive guidelines for AI coding agents working on the SignAura project, an AI-powered Sign Language Translation System.

## Project Overview

**SignAura** is a dual-stack application combining:
- **Backend**: Python-based ML system using TensorFlow/Keras for sign language recognition
- **Frontend**: PHP web application with MySQL database for user management and dashboards
- **Languages Supported**: English, Sinhala, Tamil
- **Core Technology**: MediaPipe hand landmark detection → Keras model → Multi-language text output

---

## Build, Lint, and Test Commands

### Python Backend (ML System)

#### Environment Setup
```bash
# Install dependencies
pip install -r back/requirements.txt

# Required Python version: 3.11+
```

#### Running Python Scripts
```bash
# Extract hand landmarks from dataset
python back/data_set.py

# Encode multilingual labels
python back/labele_encoder.py

# Split dataset into train/test/validation
python back/split_new_data.py

# Test text-to-speech functionality
python back/auto_multilang_tts.py
```

#### Running Jupyter Notebooks
```bash
# Start Jupyter and open notebooks
jupyter notebook back/SignAura\ \(9\).ipynb   # Model training
jupyter notebook back/liveCam.ipynb           # Real-time inference
jupyter notebook back/Data_set.ipynb          # Data exploration
```

#### Testing
- **No automated test framework currently exists**
- Manual testing through Jupyter notebooks
- Validate model output manually in `liveCam.ipynb`

#### Linting (Recommended but not configured)
```bash
# Install linting tools (not in requirements.txt)
pip install black flake8 pylint

# Format code with black
black back/*.py

# Check style with flake8
flake8 back/*.py --max-line-length=100
```

### PHP Frontend

#### Setup
```bash
# 1. Start MySQL server (XAMPP/WAMP/LAMP)
# 2. Create database: signaura_db
# 3. Import SQL schema (if available)
# 4. Configure db.php with credentials
```

#### Running PHP Application
```bash
# Using PHP built-in server (development)
php -S localhost:8000 -t front/

# Access application at: http://localhost:8000/index.php
```

#### Testing
- **No automated testing framework**
- Manual testing through browser
- Test user roles: admin and regular user
- Test authentication flow: signup → login → dashboard

#### Linting (Recommended but not configured)
```bash
# Install PHP_CodeSniffer
composer require squizlabs/php_codesniffer

# Check PHP code style
phpcs front/ --standard=PSR12

# Auto-fix code style issues
phpcbf front/ --standard=PSR12
```

---

## Code Style Guidelines

### Python Code Style

#### Imports
```python
# Standard library imports first
import os
import pickle

# Third-party imports second (alphabetically)
import cv2
import mediapipe as mp
import pandas as pd
from sklearn.preprocessing import LabelEncoder

# Local imports last (if any)
```

#### Formatting
- **Line length**: 100 characters (flexible, not enforced)
- **Indentation**: 4 spaces
- **String quotes**: Double quotes preferred for strings
- **Comments**: Use section dividers for major blocks

```python
# =========================================
# SECTION NAME
# =========================================
```

#### Naming Conventions
- **Variables**: `snake_case` (e.g., `OUTPUT_FILE`, `frame_index`, `label_col`)
- **Constants**: `UPPER_SNAKE_CASE` (e.g., `DATASET_DIR`, `ENCODER_FILE`)
- **Functions**: `snake_case` (e.g., `process_image`, `find_col`)
- **Classes**: `PascalCase` (standard but not seen in this codebase)
- **Files**: `snake_case.py` (e.g., `data_set.py`, `labele_encoder.py`)

#### Type Hints
- **Not currently used** in the codebase
- Consider adding for function signatures when writing new code:
```python
def process_image(image_path: str) -> list[float] | None:
    ...
```

#### Error Handling
- Use explicit error messages with emoji for user feedback
- Use `FileNotFoundError` for missing files
- Use `ValueError` for invalid data
- Print errors to console rather than logging

```python
if not os.path.exists(INPUT_CSV):
    raise FileNotFoundError(f"❌ '{INPUT_CSV}' not found in project folder")
```

#### Function Structure
- Keep functions focused on single responsibility
- Use early returns for error cases
- Document parameters with inline comments when needed

### PHP Code Style

#### File Structure
```php
<?php
session_start();
require_once "db.php";

// Business logic
$variable = "";

if (isset($_POST['action'])) {
    // Handle form submission
}
?>

<!DOCTYPE html>
<html lang="en">
<!-- HTML content -->
```

#### Naming Conventions
- **Variables**: `$snake_case` (e.g., `$username`, `$user_id`)
- **Functions**: `snake_case` (e.g., `escape_string`)
- **Database columns**: `snake_case` (e.g., `user_id`, `created_at`)
- **Files**: `snake_case.php` (e.g., `forgot_password.php`)

#### Database Queries
- **Always use** `mysqli_real_escape_string()` via `escape_string()` helper
- Use prepared statements for complex queries (recommended improvement)
- Limit query results appropriately

```php
$username = escape_string($conn, $_POST['username']);
$sql = "SELECT * FROM users WHERE username='$username' LIMIT 1";
```

#### Session Management
- Start sessions with `session_start()` at the top of each page
- Store user data in session: `$_SESSION['user_id']`, `$_SESSION['role']`
- Use role-based authentication checks

#### Error Messages
- Use emoji for visual feedback (⚠️, ❌, ✅, 🎉)
- Store messages in variables for display in HTML
- Example: `$message = "❌ Invalid password";`

#### HTML/CSS
- Use embedded CSS in `<style>` tags
- Font: Google Fonts - Poppins (400, 500, 600, 700)
- Color scheme: Purple (#8B5CF6) → Pink (#EC4899) → Orange (#F97316)
- Design: Glassmorphism with backdrop blur effects

---

## Project Structure

```
SignAura/
├── back/                           # Python ML Backend (70MB)
│   ├── data_set.py                 # Extract hand landmarks from images/videos
│   ├── labele_encoder.py           # Encode multilingual labels
│   ├── split_new_data.py           # Train/test/validation split
│   ├── auto_multilang_tts.py       # Text-to-speech utility
│   ├── SignAura (9).ipynb          # Model training notebook
│   ├── liveCam.ipynb               # Real-time webcam inference
│   ├── Data_Set.csv                # Training data (hand landmarks)
│   ├── labels_new.csv              # Label mappings (EN/SI/TA)
│   ├── model.keras                 # Trained Keras model (407KB)
│   ├── label_encoder_382.pkl       # LabelEncoder for 382 classes
│   └── requirements.txt            # Python dependencies
│
└── front/                          # PHP Web Frontend
    ├── index.php                   # Landing page
    ├── signup.php                  # User registration
    ├── login.php                   # Authentication
    ├── logout.php                  # Session cleanup
    ├── forgot_password.php         # Password recovery
    ├── reset_password.php          # Password reset
    ├── db.php                      # Database connection
    ├── admin/                      # Admin panel
    │   ├── dashboard.php
    │   ├── users.php
    │   ├── feedback.php
    │   └── history.php
    └── user/                       # User dashboard
        ├── dashboard.php
        └── History_feedback.php
```

---

## Key Technologies

### Backend Stack
- TensorFlow 2.12.0 + Keras 2.12.0
- MediaPipe 0.10.14 (hand landmark detection)
- OpenCV 4.12.0 (image/video processing)
- Pandas 2.3.3, NumPy 1.23.5
- Scikit-learn 1.7.2

### Frontend Stack
- PHP (no framework)
- MySQL (mysqli driver)
- Bootstrap 5.3.2 (CDN)
- Vanilla JavaScript (minimal)

---

## Development Workflow

When making changes to this codebase:

1. **Python changes**: Test with Jupyter notebooks before committing
2. **PHP changes**: Test in browser with both admin and user roles
3. **Database changes**: Update schema documentation
4. **Model changes**: Retrain and validate accuracy before deployment
5. **Always validate**: Multi-language support (English, Sinhala, Tamil)

---

## Important Notes

- **No Node.js/npm**: This is NOT a JavaScript project
- **No TypeScript**: Pure Python and PHP codebase
- **No build step**: Direct execution of scripts
- **Hardcoded paths**: Update `DATASET_DIR` in `data_set.py` for your environment
- **Database credentials**: Located in `front/db.php` (localhost/root/no password)
- **382 sign language classes**: Comprehensive gesture recognition
- **Emoji usage**: Consistently used for user feedback throughout codebase
