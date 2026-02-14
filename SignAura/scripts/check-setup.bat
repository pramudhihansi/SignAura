@echo off
REM Quick Start Script for SignAura
REM Run this to check if everything is set up correctly

echo ╔════════════════════════════════════════════════════════════╗
echo ║           SignAura - Quick Start Checker                  ║
echo ╚════════════════════════════════════════════════════════════╝
echo.

echo [1/6] Checking Python installation...
python --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Python not found! Install Python 3.11+ first.
    pause
    exit /b 1
) else (
    python --version
    echo ✓ Python found
)
echo.

echo [2/6] Checking PHP installation...
php -v >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ PHP not found! Install XAMPP first.
    pause
    exit /b 1
) else (
    php -v | findstr "PHP"
    echo ✓ PHP found
)
echo.

echo [3/6] Checking MySQL...
mysql --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ⚠️  MySQL command not in PATH (OK if using XAMPP GUI)
) else (
    mysql --version
    echo ✓ MySQL found
)
echo.

echo [4/6] Checking project structure...
if exist "api\app.py" (
    echo ✓ api\app.py exists
) else (
    echo ❌ api\app.py missing!
)

if exist "web\public\index.php" (
    echo ✓ web\public\index.php exists
) else (
    echo ❌ web\public\index.php missing!
)

if exist "ml-models\model.keras" (
    echo ✓ ml-models\model.keras exists
) else (
    echo ❌ ml-models\model.keras missing!
)

if exist "database\schema.sql" (
    echo ✓ database\schema.sql exists
) else (
    echo ❌ database\schema.sql missing!
)
echo.

echo [5/6] Checking Python virtual environment...
if exist "api\venv\Scripts\python.exe" (
    echo ✓ Virtual environment exists
    echo.
    echo Testing packages...
    api\venv\Scripts\python.exe -c "import flask; print('  ✓ Flask installed')" 2>nul || echo "  ❌ Flask not installed - run: pip install -r requirements.txt"
    api\venv\Scripts\python.exe -c "import tensorflow; print('  ✓ TensorFlow installed')" 2>nul || echo "  ❌ TensorFlow not installed"
) else (
    echo ❌ Virtual environment not created
    echo    Run: cd api ^&^& python -m venv venv
)
echo.

echo [6/6] Checking XAMPP services...
tasklist | findstr "httpd.exe" >nul 2>&1
if %errorlevel% equ 0 (
    echo ✓ Apache is running
) else (
    echo ⚠️  Apache not running - start it in XAMPP Control Panel
)

tasklist | findstr "mysqld.exe" >nul 2>&1
if %errorlevel% equ 0 (
    echo ✓ MySQL is running
) else (
    echo ⚠️  MySQL not running - start it in XAMPP Control Panel
)
echo.

echo ════════════════════════════════════════════════════════════
echo.
echo 📖 Next steps:
echo.
echo 1. If virtual environment missing:
echo    cd api
echo    python -m venv venv
echo    venv\Scripts\activate
echo    pip install -r requirements.txt
echo.
echo 2. Setup database:
echo    - Open http://localhost/phpmyadmin
echo    - Create database: signaura_db
echo    - Import: database\schema.sql
echo.
echo 3. Run the application:
echo    Terminal 1: cd api ^&^& venv\Scripts\activate ^&^& python app.py
echo    Terminal 2: cd web\public ^&^& php -S localhost:8000
echo.
echo 4. Open browser:
echo    http://localhost:8000
echo.
echo ════════════════════════════════════════════════════════════
echo.
pause
