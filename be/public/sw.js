/* YogaRoots member SW — ringan: cache aset statis, navigasi network-first. */
const CACHE = 'yogaroots-mobile-v1';
const STATIC_PATTERNS = [
  /\/dist\//,
  /\/img\//,
  /\/css\//,
  /cdn\.jsdelivr\.net/,
  /fonts\.gstatic\.com/,
];

self.addEventListener('install', (event) => {
  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) =>
      Promise.all(keys.filter((k) => k !== CACHE).map((k) => caches.delete(k)))
    ).then(() => self.clients.claim())
  );
});

function isStatic(url) {
  return STATIC_PATTERNS.some((re) => re.test(url));
}

self.addEventListener('fetch', (event) => {
  const req = event.request;
  if (req.method !== 'GET') return;

  const url = new URL(req.url);

  // Navigasi: network-first, fallback offline.
  if (req.mode === 'navigate') {
    event.respondWith(
      fetch(req).catch(() =>
        new Response(
          '<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Offline — YogaRoots</title>' +
          '<style>body{font-family:system-ui,sans-serif;background:#faf8f2;color:#31392f;display:flex;min-height:100vh;align-items:center;justify-content:center;margin:0}' +
          '.c{text-align:center;padding:24px}h1{font-size:20px}</style></head>' +
          '<body><div class="c"><h1>Kamu sedang offline</h1><p>Periksa koneksi lalu coba lagi.</p><button onclick="location.reload()">Muat ulang</button></div></body></html>',
          { headers: { 'Content-Type': 'text/html; charset=UTF-8' } }
        )
      )
    );
    return;
  }

  // Aset statis: cache-first.
  if (isStatic(url.href)) {
    event.respondWith(
      caches.open(CACHE).then((cache) =>
        cache.match(req).then((hit) => {
          const net = fetch(req).then((res) => {
            if (res && (res.ok || res.type === 'opaque')) cache.put(req, res.clone());
            return res;
          }).catch(() => hit);
          return hit || net;
        })
      )
    );
  }
});
