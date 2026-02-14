@echo off
REM Start the Flask API server for SignAura

echo Starting SignAura Flask API Server...
echo.

cd /d "%~dp0.."

if exist "api\venv\Scripts\activate.bat" (
    echo Activating virtual environment...
    call api\venv\Scripts\activate.bat
    echo.
    echo Starting Flask API on http://localhost:5000
    echo Press Ctrl+C to stop the server
    echo.
    cd api
    python app.py
) else (
    echo ❌ Virtual environment not found!
    echo Please run: setup-python.bat
    pause
)
