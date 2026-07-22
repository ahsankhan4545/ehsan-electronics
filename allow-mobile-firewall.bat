@echo off
:: Request Administrator rights
net session >nul 2>&1
if %errorLevel% NEQ 0 (
  echo Administrator permission chahiye...
  powershell -Command "Start-Process -FilePath '%~f0' -Verb RunAs"
  exit /b
)

echo Firewall mein port 8000 allow kar rahe hain...
netsh advfirewall firewall delete rule name="Ehsan Electronics 8000" >nul 2>&1
netsh advfirewall firewall add rule name="Ehsan Electronics 8000" dir=in action=allow protocol=TCP localport=8000 profile=any

echo.
echo Done.
echo Ab phone pe open karo:
echo   http://10.40.157.212:8000
echo.
echo Pehle open-on-mobile.bat chalao / server running ho.
echo Phone aur PC SAME Wi-Fi pe hon.
echo.
pause
