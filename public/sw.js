/* Ehsan Electronics — lightweight offline shell cache (static assets only) */
const CACHE_NAME = 'ehsan-electronics-shell-v1';
const SHELL_URLS = [
  '/',
  '/manifest.webmanifest',
  '/icons/icon-192.png',
  '/icons/icon-512.png',
];

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

  const url = new URL(req.url);

  // Same-origin only
  if (url.origin !== self.location.origin) {
    return;
  }

  // Bypass API-ish / mutating Laravel routes and auth flows
  if (
    url.pathname.startsWith('/admin') ||
    url.pathname.startsWith('/sanctum') ||
    url.pathname.startsWith('/livewire') ||
    url.pathname.includes('/checkout') ||
    url.pathname.includes('/cart') ||
    url.pathname.includes('/login') ||
    url.pathname.includes('/register') ||
    url.pathname.includes('/logout')
  ) {
    return;
  }

  // Network-first for HTML navigations (keep CSRF/session fresh)
  if (req.mode === 'navigate' || (req.headers.get('accept') || '').includes('text/html')) {
    event.respondWith(
      fetch(req)
        .then((res) => {
          const copy = res.clone();
          caches.open(CACHE_NAME).then((cache) => cache.put(req, copy));
          return res;
        })
        .catch(() => caches.match(req).then((cached) => cached || caches.match('/')))
    );
    return;
  }

  // Cache-first for static build assets & icons
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
