@echo off
REM Setup script for SignAura - Auto-detects Python 3.10 or 3.11
REM TensorFlow 2.12 requires Python 3.8-3.11 (NOT 3.12+)

echo ╔════════════════════════════════════════════════════════════╗
echo ║         SignAura Setup - Auto-detecting Python             ║
echo ╚════════════════════════════════════════════════════════════╝
echo.

echo [1/5] Checking Python installation (3.10 or 3.11)...

REM Try Python 3.11 first
py -3.11 --version >nul 2>&1
if %errorlevel% equ 0 (
    set PYTHON_CMD=py -3.11
    set PYTHON_VER=3.11
    echo ✓ Python 3.11 found
    goto :python_found
)

REM Try Python 3.10 if 3.11 not found
py -3.10 --version >nul 2>&1
if %errorlevel% equ 0 (
    set PYTHON_CMD=py -3.10
    set PYTHON_VER=3.10
    echo ✓ Python 3.10 found
    goto :python_found
)

REM Neither found
echo.
echo ❌ Python 3.10 or 3.11 not found!
echo.
echo TensorFlow 2.12 requires Python 3.10 or 3.11
echo Please install Python from: https://www.python.org/downloads/
echo.
echo IMPORTANT: Do NOT install Python 3.12 or 3.13 - not supported!
echo.
pause
exit /b 1

:python_found
echo.

echo [2/5] Navigating to api directory...
cd /d "%~dp0.."
cd api
if %errorlevel% neq 0 (
    echo ❌ api directory not found!
    pause
    exit /b 1
)
echo ✓ In api directory
echo.

echo [3/5] Creating virtual environment with Python %PYTHON_VER%...
%PYTHON_CMD% -m venv venv
if %errorlevel% neq 0 (
    echo ❌ Failed to create virtual environment!
    pause
    exit /b 1
)
echo ✓ Virtual environment created
echo.

echo [4/5] Activating virtual environment...
call venv\Scripts\activate.bat
if %errorlevel% neq 0 (
    echo ❌ Failed to activate virtual environment!
    pause
    exit /b 1
)
echo ✓ Virtual environment activated
echo.

echo [5/5] Installing Python packages (this may take 5-10 minutes)...
echo.
echo Installing packages from requirements.txt...
echo (TensorFlow, MediaPipe, OpenCV, Flask, etc.)
echo.
python -m pip install --upgrade pip
pip install -r requirements.txt
if %errorlevel% neq 0 (
    echo.
    echo ⚠️  Some packages may have failed to install.
    echo Check the errors above.
    pause
    exit /b 1
)
echo.
echo ╔════════════════════════════════════════════════════════════╗
echo ║                  ✅ Setup Complete!                        ║
echo ╚════════════════════════════════════════════════════════════╝
echo.
echo Installed Python version:
python --version
echo.
echo Virtual environment: api\venv
echo.
echo Next steps:
echo   1. Keep this window open (venv is already activated)
echo   2. Run: run-api.bat  (starts Flask API)
echo   3. Run: run-web.bat  (starts PHP web server)
echo   4. Open: http://localhost:8000
echo.
echo For more info, see: mdFiles\START_HERE.md
echo.
echo Press any key to exit (virtual environment will stay activated)
pause
