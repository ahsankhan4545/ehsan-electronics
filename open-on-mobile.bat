@echo off
setlocal EnableDelayedExpansion
cd /d "%~dp0"
title Ehsan Electronics - Mobile Access
color 0A

echo.
echo ============================================
echo   Ehsan Electronics - Mobile QR
echo ============================================
echo.

set "LAN_IP="
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /c:"IPv4 Address"') do (
  set "RAW=%%a"
  set "RAW=!RAW: =!"
  echo !RAW! | findstr /b "10." >nul && if not defined LAN_IP set "LAN_IP=!RAW!"
  echo !RAW! | findstr /b "192.168." >nul && if not defined LAN_IP set "LAN_IP=!RAW!"
)

if not defined LAN_IP set "LAN_IP=10.40.157.212"

echo   PC pe QR page:
echo     http://127.0.0.1:8000/mobile
echo.
echo   Phone pe YE link open / scan karo:
echo     http://!LAN_IP!:8000
echo.
echo   Rules:
echo   - Phone + PC same Wi-Fi
echo   - Is window band na karo
echo ============================================
echo.

start "" "http://127.0.0.1:8000/mobile"

netstat -ano | findstr ":8000" | findstr "LISTENING" >nul
if !errorlevel! == 0 (
  echo   Server pehle se chal raha hai. Phone se QR scan karo.
  echo.
  pause
  exit /b 0
)

echo   Server start...
php artisan serve --host=0.0.0.0 --port=8000
echo.
echo   Server band ho gaya.
pause
