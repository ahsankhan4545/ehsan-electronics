<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#fed700">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Ehsan Electronics">
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192.png') }}">
    <title>Ehsan Electronics — Get App / QR</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 640px;
            margin: 0 auto;
            padding: max(24px, env(safe-area-inset-top)) 16px max(32px, env(safe-area-inset-bottom));
            background: #222;
            color: #eee;
        }
        h1 { font-size: 26px; margin: 12px 0 6px; }
        h1 span { color: #fed700; }
        h2 { font-size: 18px; margin: 0 0 8px; color: #fed700; }
        .muted { color: #aaa; font-size: 14px; line-height: 1.5; }
        .card {
            background: #333;
            border: 1px solid #444;
            border-radius: 14px;
            padding: 20px;
            margin: 16px 0;
            text-align: center;
        }
        .card.primary { border-color: #fed700; box-shadow: 0 0 0 1px rgba(254, 215, 0, 0.25); }
        a.btn {
            display: inline-block;
            margin-top: 12px;
            padding: 12px 18px;
            background: #fed700;
            color: #222;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            word-break: break-all;
        }
        a.btn.secondary { background: #444; color: #fed700; border: 1px solid #555; }
        code { color: #fed700; word-break: break-all; }
        img.qr { background: white; padding: 14px; border-radius: 12px; margin-top: 14px; max-width: 100%; height: auto; }
        .back { color: #fed700; text-decoration: none; font-size: 14px; }
        ol.muted { text-align: left; padding-left: 20px; }
        .steps { text-align: left; margin-top: 12px; }
        .steps li { margin-bottom: 8px; }
    </style>
</head>
<body>
    <a class="back" href="{{ url('/') }}">← Back to Store</a>
    <h1>Ehsan <span>Electronics</span></h1>
    <p class="muted">
        <strong>Scan QR → phone pe store kholo → Install App / Add to Home Screen</strong><br>
        Phone pe app jaisa experience ke liye Home Screen pe add karo.
    </p>

    <div class="card primary">
        <h2>📱 Live Store QR (scan this)</h2>
        <p class="muted">Public URL — production / APP_URL</p>
        <p><code>{{ $publicUrl }}</code></p>
        <div>
            <img class="qr" width="260" height="260"
                 src="https://api.qrserver.com/v1/create-qr-code/?size=260x260&data={{ urlencode($publicUrl) }}"
                 alt="QR code for Ehsan Electronics store">
        </div>
        <a class="btn" href="{{ $publicUrl }}" target="_blank" rel="noopener">Open Store</a>
        <div class="steps muted">
            <ol>
                <li>Phone camera se ye QR scan karo</li>
                <li>Store browser mein khulega</li>
                <li><strong>Android:</strong> menu → <em>Install app</em> / <em>Add to Home screen</em></li>
                <li><strong>iPhone:</strong> Share → <em>Add to Home Screen</em></li>
            </ol>
        </div>
    </div>

    @if ($lanUrl && $lanUrl !== $publicUrl)
        <div class="card">
            <h2>Same Wi‑Fi (local dev)</h2>
            <p><code>{{ $lanUrl }}</code></p>
            <a class="btn secondary" href="{{ $lanUrl }}" target="_blank" rel="noopener">Open LAN</a>
            <div>
                <img class="qr" width="180" height="180"
                     src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode($lanUrl) }}"
                     alt="QR LAN">
            </div>
            <p class="muted">Sirf jab PC pe local server chal raha ho — phone aur PC same Wi‑Fi pe hon.</p>
        </div>
    @endif

    @if ($currentUrl !== $publicUrl)
        <div class="card">
            <h2>This page’s host</h2>
            <p><code>{{ $currentUrl }}</code></p>
            <a class="btn secondary" href="{{ $currentUrl }}" target="_blank" rel="noopener">Open</a>
            <div>
                <img class="qr" width="180" height="180"
                     src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode($currentUrl) }}"
                     alt="QR current host">
            </div>
        </div>
    @endif

    <div class="card">
        <h2>Install tips</h2>
        <ol class="muted">
            <li>Chrome / Safari se store kholo (upar wala live QR)</li>
            <li>Install / Add to Home Screen choose karo</li>
            <li>Icon tap karke app jaisa full-screen store khulega</li>
        </ol>
    </div>

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register('{{ asset('sw.js') }}').catch(function () {});
            });
        }
    </script>
</body>
</html>
