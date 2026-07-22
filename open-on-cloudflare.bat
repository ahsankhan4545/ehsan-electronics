@echo off
cd /d "%~dp0"
title CLOUDFLARE LINK - Ehsan Electronics
color 0B

echo.
echo ################################################
echo   YE FILE CLOUDFLARE ke liye hai
echo   (open-on-mobile.bat LOCAL link deti hai)
echo ################################################
echo.
echo Neeche https://xxxx.trycloudflare.com dikhega
echo Wahi phone pe open karo.
echo Is window ko BAND MAT KARNA.
echo.
echo ################################################
echo.

:: Start Laravel server in another window
start "Ehsan Store Server" cmd /k "cd /d ""%~dp0"" && php artisan serve --host=127.0.0.1 --port=8000"
timeout /t 5 /nobreak >nul

echo.
echo Cloudflare tunnel start ho raha hai...
echo Agar pehli dafa ho to download thoda wait karega...
echo.
echo ========== CLOUDFLARE HTTPS LINK YAHAN ==========
echo.

if exist "%~dp0cloudflared.exe" (
  "%~dp0cloudflared.exe" tunnel --url http://127.0.0.1:8000
) else (
  echo cloudflared.exe nahi mila — npx se chala rahe hain...
  call npx --yes cloudflared@latest tunnel --url http://127.0.0.1:8000
)

echo.
echo Tunnel band ho gaya.
pause
