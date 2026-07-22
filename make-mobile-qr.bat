@echo off
setlocal
cd /d "%~dp0"
title Make Mobile QR from Cloudflare URL

echo.
echo Cloudflare window se https URL copy karo
echo Example: https://something.trycloudflare.com
echo.
set /p CF_URL=Paste Cloudflare URL here: 

if "%CF_URL%"=="" (
  echo URL empty. Exit.
  pause
  exit /b 1
)

:: trim trailing slash
if "%CF_URL:~-1%"=="/" set "CF_URL=%CF_URL:~0,-1%"

powershell -NoProfile -Command ^
  "$u=[uri]'%CF_URL%'; $enc=[uri]::EscapeDataString('%CF_URL%'); $mobile=[uri]::EscapeDataString('%CF_URL%/mobile'); @"
<!DOCTYPE html>
<html lang='en'>
<head>
  <meta charset='UTF-8' />
  <meta name='viewport' content='width=device-width, initial-scale=1.0' />
  <title>Ehsan Electronics Mobile QR</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 640px; margin: 40px auto; padding: 0 16px; background: #222; color: #eee; }
    h1 { font-size: 26px; } h1 span { color: #fed700; }
    .card { background: #333; border: 1px solid #444; border-radius: 14px; padding: 20px; margin: 16px 0; }
    a.btn { display: inline-block; margin-top: 10px; padding: 12px 16px; background: #fed700; color: #222; text-decoration: none; border-radius: 8px; font-weight: bold; word-break: break-all; }
    code { color: #fed700; } img { background: white; padding: 12px; border-radius: 12px; margin-top: 12px; }
    .muted { color: #aaa; font-size: 14px; }
  </style>
</head>
<body>
  <h1>Ehsan <span>Electronics</span></h1>
  <p class='muted'>Cloudflare public link — phone se QR scan karo.</p>
  <div class='card'>
    <h2>Store Link</h2>
    <p><code>%CF_URL%</code></p>
    <a class='btn' href='%CF_URL%' target='_blank'>Open Store</a>
    <div><img src='https://api.qrserver.com/v1/create-qr-code/?size=240x240&data=$enc' alt='QR Store' /></div>
  </div>
  <div class='card'>
    <h2>Mobile QR Page</h2>
    <p><code>%CF_URL%/mobile</code></p>
    <a class='btn' href='%CF_URL%/mobile' target='_blank'>Open</a>
    <div><img src='https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=$mobile' alt='QR Mobile' /></div>
  </div>
</body>
</html>
"@ | Set-Content -Encoding UTF8 -Path 'MOBILE-OPEN.html'"

echo.
echo MOBILE-OPEN.html update ho gaya.
start "" "%~dp0MOBILE-OPEN.html"
pause
