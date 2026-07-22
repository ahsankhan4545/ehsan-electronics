<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ehsan Electronics — Mobile QR</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 640px; margin: 40px auto; padding: 0 16px; background: #222; color: #eee; }
        h1 { font-size: 26px; margin-bottom: 6px; }
        h1 span { color: #fed700; }
        .muted { color: #aaa; font-size: 14px; }
        .card { background: #333; border: 1px solid #444; border-radius: 14px; padding: 20px; margin: 16px 0; }
        a.btn { display: inline-block; margin-top: 10px; padding: 12px 16px; background: #fed700; color: #222; text-decoration: none; border-radius: 8px; font-weight: bold; word-break: break-all; }
        code { color: #fed700; }
        img { background: white; padding: 12px; border-radius: 12px; margin-top: 12px; }
        .back { color: #fed700; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>
    <a class="back" href="{{ url('/') }}">← Back to Store</a>
    <h1>Ehsan <span>Electronics</span></h1>
    <p class="muted">Phone pe store kholne ke liye QR scan karo (appointment platform jaisa).</p>

    @if ($lanUrl)
        <div class="card">
            <h2>1) Same Wi‑Fi (recommended)</h2>
            <p><code>{{ $lanUrl }}</code></p>
            <a class="btn" href="{{ $lanUrl }}" target="_blank">Open on this device</a>
            <div>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={{ urlencode($lanUrl) }}" alt="QR LAN">
            </div>
            <p class="muted">Phone aur PC same Wi‑Fi / hotspot pe hon. Server <code>0.0.0.0</code> pe chalna chahiye.</p>
        </div>
    @else
        <div class="card">
            <h2>LAN IP nahi mila</h2>
            <p class="muted">Wi‑Fi connect karke page refresh karo, ya neeche localhost QR use karo.</p>
        </div>
    @endif

    <div class="card">
        <h2>2) Current link</h2>
        <p><code>{{ $currentUrl }}</code></p>
        <a class="btn" href="{{ $currentUrl }}" target="_blank">Open Store</a>
        <div>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={{ urlencode($currentUrl) }}" alt="QR Current">
        </div>
        <p class="muted">Agar ye <code>127.0.0.1</code> hai to phone pe nahi chalega — upar wala Wi‑Fi QR use karo.</p>
    </div>

    <div class="card">
        <h2>3) Kaise run karein (mobile ke liye)</h2>
        <ol class="muted">
            <li>Project folder mein <code>open-on-mobile.bat</code> double‑click karo</li>
            <li>Ya command: <code>php artisan serve --host=0.0.0.0 --port=8000</code></li>
            <li>Is page ko PC pe kholo: <code>http://127.0.0.1:8000/mobile</code></li>
            <li>Phone camera se QR scan karo</li>
        </ol>
    </div>
</body>
</html>
