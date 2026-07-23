/* Ehsan Electronics — lightweight offline shell cache (static assets only) */
const CACHE_NAME = 'ehsan-electronics-shell-v3';
const SHELL_URLS = [
  '/manifest.webmanifest',
  '/icons/icon-192.png',
  '/icons/icon-512.png',
];

/** Paths that must never be intercepted / cached (session, CSRF, cart, auth). */
function isSensitivePath(pathname) {
  return (
    pathname.startsWith('/admin') ||
    pathname.startsWith('/sanctum') ||
    pathname.startsWith('/livewire') ||
    pathname.startsWith('/api') ||
    pathname.startsWith('/cart') ||
    pathname.startsWith('/checkout') ||
    pathname.startsWith('/login') ||
    pathname.startsWith('/register') ||
    pathname.startsWith('/logout') ||
    pathname.startsWith('/orders') ||
    pathname.startsWith('/profile') ||
    pathname.startsWith('/notifications') ||
    pathname.includes('/csrf')
  );
}

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => cache.addAll(SHELL_URLS)).then(() => self.skipWaiting())
  );
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) =>
      Promise.all(keys.filter((k) => k !== CACHE_NAME).map((k) => caches.delete(k)))
    ).then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', (event) => {
  const req = event.request;

  // Never intercept non-GET (POST/PUT with CSRF, forms, etc.)
  if (req.method !== 'GET') {
    return;
  }

  let url;
  try {
    url = new URL(req.url);
  } catch (_) {
    return;
  }

  // Same-origin only
  if (url.origin !== self.location.origin) {
    return;
  }

  // Network-only for cart / checkout / auth / CSRF / admin / API
  if (isSensitivePath(url.pathname)) {
    return;
  }

  // Do not intercept HTML navigations — let the browser handle cookies/session natively.
  // Caching HTML previously served stale empty-cart shells on mobile / PWA.
  if (req.mode === 'navigate' || (req.headers.get('accept') || '').includes('text/html')) {
    return;
  }

  // Cache-first for static build assets & icons only
  if (
    url.pathname.startsWith('/build/') ||
    url.pathname.startsWith('/icons/') ||
    url.pathname === '/manifest.webmanifest' ||
    url.pathname.endsWith('.css') ||
    url.pathname.endsWith('.js') ||
    url.pathname.endsWith('.woff2') ||
    url.pathname.endsWith('.png') ||
    url.pathname.endsWith('.jpg') ||
    url.pathname.endsWith('.webp') ||
    url.pathname.endsWith('.svg')
  ) {
    event.respondWith(
      caches.match(req).then((cached) => {
        if (cached) {
          return cached;
        }
        return fetch(req).then((res) => {
          if (res.ok) {
            const copy = res.clone();
            caches.open(CACHE_NAME).then((cache) => cache.put(req, copy));
          }
          return res;
        });
      })
    );
  }
});
