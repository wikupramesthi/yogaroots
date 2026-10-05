# YogaRoots FE — Theme (Tailwind CSS v4 + EJS + Express)

Theme frontend YogaRoots. Konten dinamis diambil dari backend Laravel via `src/services/`.

## Cara jalan

```bash
cp .env.example .env   # sesuaikan API_URL, SITE_URL, WHATSAPP_NUMBER
npm install
npm run build:css      # build sekali
npm run dev            # server http://localhost:3000
```

## Struktur

```
fe/
├── server.js                 # bootstrap tipis (tidak ada logika route di sini)
├── .env / .env.example      # API_URL, SITE_URL, GOOGLE_AUTH_URL, WHATSAPP_NUMBER, ASSET_V, HTML_MINIFY, PORT
├── src/
│   ├── config/env.js         # env tervalidasi + link terpusat (WA, OAuth) + ASSET_V + HTML_MINIFY
│   ├── middleware/security.js# helmet CSP, rate limit, origin check
│   ├── middleware/locals.js  # site/nav/contactLinks/currentUrl/assetV (anti host-injection)
│   ├── middleware/i18n.js    # ?lang=en|id|ja|ko|zh, cookie HttpOnly
│   ├── middleware/minify.js  # HTML minify — view-source ringkas, file EJS tetap rapi
│   ├── middleware/errors.js  # 404 + error handler
│   ├── routes/pages.js       # semua GET halaman (validasi slug/query, sanitasi HTML)
│   ├── routes/api.js         # /api/* (validasi body, rate-limit)
│   ├── services/             # client backend (apiClient + buildQuery + per-resource)
│   │   └── apiClient.js      # base URL dari env, timeout 10 dtk, buildQuery whitelist
│   ├── data/
│   │   ├── yogaData.js       # HANYA site/nav/contact statis
│   │   └── translations.js   # string i18n en|id|ja|ko|zh (tambah bahasa = tambah key + daftarkan di i18n.js)
│   └── utils/validate.js     # validator input
│   └── utils/sanitize.js     # sanitasi HTML CMS (sanitize-html)
├── views/
│   ├── partials/             # head, navbar, footer (+whatsapp-float, booking-modal, cta-help;
│   │                         # footer memuat /js/main.js SEKALI untuk semua halaman)
│   └── pages/                # 14 halaman (full HTML + include partials)
└── public/js/main.js         # interaksi (modal, form, lightbox, cookie consent)
```

## Aturan kerapian

- Tidak ada URL/nomor hardcode di views, public/js & services — lewat `contactLinks` / `env` / `site` (footer pakai `site.phone`, `site.instagram`, `contactLinks.*`; `main.js` wajib baca `data-wa-base`).
- Blok UI yang dipakai >1 halaman wajib jadi partial (`cta-help`, `booking-modal`, `whatsapp-float`; `footer` memuat `main.js` sekali — jangan duplikasi `<script>` di pages).
- Semua input (slug, query, body POST) wajib lewat `src/utils/validate.js`.
- HTML dari CMS wajib lewat `sanitizeRichHtml()` sebelum `<%- ... %>`.
- Tidak ada `console.log` PII di route — booking hanya `console.debug` saat non-prod, error masuk `errorHandler`.
- Query backend wajib lewat `buildQuery(params, whitelist)` di `src/services/apiClient.js`.
- HTML yang dikirim ke browser di-minify (`minifyHtml`, default `HTML_MINIFY=1`) — view-source ringkas; set `HTML_MINIFY=0` kalau butuh view-source readable saat debug.

## API internal

- `GET /api/classes` → proxy rapi ke backend
- `POST /api/booking` `{name,email,kelas,date?}` → validasi ketat
- `POST /api/contact` `{name,email,subject?,message,captcha?}` → teruskan ke backend
- `POST /api/newsletter` `{email}`

## Halaman & route

`/`, `/about`, `/classes`, `/classes/:slug`, `/schedules`, `/pages/:slug`, `/instructors`,
`/blog`, `/blog/:slug`, `/packages`, `/packages/:slug`, `/event`,
`/gallery`, `/contact`

## SEO

- `/sitemap.xml` dinamis (10 URL statis + slug classes/packages/blog/pages dari backend, cache 1 jam, fail-open)
- `/robots.txt` dinamis dengan `Sitemap:` absolut mengikuti `SITE_URL`
