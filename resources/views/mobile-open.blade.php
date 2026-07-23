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
    <title>Ehsan Electronics — Get App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 520px;
            margin: 0 auto;
            padding: max(24px, env(safe-area-inset-top)) 16px max(32px, env(safe-area-inset-bottom));
            background: #222;
            color: #eee;
            text-align: center;
        }
        h1 { font-size: 28px; margin: 16px 0 8px; }
        h1 span { color: #fed700; }
        h2 { font-size: 18px; margin: 0 0 10px; color: #fed700; }
        .muted { color: #aaa; font-size: 14px; line-height: 1.55; }
        .card {
            background: #333;
            border: 1px solid #444;
            border-radius: 16px;
            padding: 24px 20px;
            margin: 20px 0;
        }
        .card.primary { border-color: #fed700; }
        a.btn {
            display: inline-block;
            margin-top: 14px;
            padding: 12px 20px;
            background: #fed700;
            color: #222;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }
        code { color: #fed700; word-break: break-all; font-size: 13px; }
        img.qr {
            background: #fff;
            padding: 16px;
            border-radius: 14px;
            margin: 16px auto 0;
            display: block;
            max-width: 100%;
            height: auto;
        }
        .back { color: #fed700; text-decoration: none; font-size: 14px; display: inline-block; margin-bottom: 8px; }
        ol { text-align: left; padding-left: 22px; margin: 12px 0 0; }
        ol li { margin-bottom: 10px; }
        .dev { margin-top: 28px; padding-top: 16px; border-top: 1px solid #444; text-align: left; }
        .dev img.qr { margin-left: 0; width: 120px; height: 120px; padding: 8px; }
    </style>
</head>
<body>
    <a class="back" href="{{ url('/') }}">← Back to Store</a>
    <h1>Ehsan <span>Electronics</span></h1>
    <p class="muted">
        Phone se <strong>QR scan</strong> karo → live store khulega → <strong>Install App</strong> / Add to Home Screen.
    </p>

    <div class="card primary">
        <h2>Scan this QR</h2>
        <p class="muted">Live store URL</p>
        <p><code>{{ $publicUrl }}</code></p>
        <img class="qr" width="280" height="280"
             src="https://api.qrserver.com/v1/create-qr-code/?size=280x280&data={{ urlencode($publicUrl) }}"
             alt="QR code for {{ $publicUrl }}">
        <a class="btn" href="{{ $publicUrl }}">Open Store</a>
    </div>

    <div class="card">
        <h2>Install as app</h2>
        <ol class="muted">
            <li><strong>Android (Chrome):</strong> menu ⋮ → <em>Install app</em> ya <em>Add to Home screen</em></li>
            <li><strong>iPhone (Safari):</strong> Share □↑ → <em>Add to Home Screen</em></li>
            <li>Home screen pe icon tap karo — app jaisa full-screen store</li>
        </ol>
    </div>

    @if (!empty($showDevQr) && $lanUrl)
        <div class="dev muted">
            <p><strong>Local Wi‑Fi only (dev):</strong> <code>{{ $lanUrl }}</code></p>
            <img class="qr" width="120" height="120"
                 src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ urlencode($lanUrl) }}"
                 alt="LAN QR (dev)">
        </div>
    @endif

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register('{{ asset('sw.js') }}?v=3').then(function (reg) {
                    reg.update();
                }).catch(function () {});
            });
        }
    </script>
</body>
</html>
