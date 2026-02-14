@echo off
REM Quick script to run PHP development server

echo Starting SignAura PHP Web Server...
echo.

cd /d "%~dp0..\web"

echo Starting PHP server on http://localhost:8000
echo Press Ctrl+C to stop the server
echo.

php -S localhost:8000 -t public

pause
