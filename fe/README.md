# YogaRoots FE — Theme (Tailwind CSS v4 + EJS + Express)

Theme frontend YogaRoots. Konten dinamis diambil dari backend Laravel via `services/`.

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
├── .env / .env.example      # API_URL, SITE_URL, GOOGLE_AUTH_URL, WHATSAPP_NUMBER
├── src/
│   ├── config/env.js         # env tervalidasi + link terpusat (WA, OAuth)
│   ├── middleware/security.js# helmet CSP, rate limit, origin check
│   ├── middleware/locals.js  # site/nav/contactLinks/currentUrl (anti host-injection)
│   ├── middleware/i18n.js    # ?lang=en|id|ja|ko|zh, cookie HttpOnly
│   ├── middleware/errors.js  # 404 + error handler
│   ├── routes/pages.js       # semua GET halaman (validasi slug/query, sanitasi HTML)
│   ├── routes/api.js         # /api/* (validasi body, rate-limit)
│   └── utils/validate.js     # validator input
│   └── utils/sanitize.js     # sanitasi HTML CMS (sanitize-html)
├── services/                 # client backend (apiClient + per-resource)
│   └── apiClient.js          # base URL dari env, timeout 10 dtk
├── data/
│   ├── yogaData.js           # HANYA site/nav/contact statis
│   └── translations.js       # string i18n en|id|ja|ko|zh (tambah bahasa = tambah key + daftarkan di i18n.js)
├── views/
│   ├── partials/             # head, navbar, footer, cta-help, booking-modal,
│   │                         # whatsapp-float, cookie-consent (masing2 1 tanggung jawab)
│   └── pages/                # 14 halaman (full HTML + include partials)
└── public/js/main.js         # interaksi (modal, form, lightbox, cookie consent)
```

## Aturan kerapian

- Tidak ada URL/nomor hardcode di views & services — lewat `contactLinks` / `env`.
- Blok UI yang dipakai >1 halaman wajib jadi partial (`cta-help`, `booking-modal`, `whatsapp-float`).
- Semua input (slug, query, body POST) wajib lewat `src/utils/validate.js`.
- HTML dari CMS wajib lewat `sanitizeRichHtml()` sebelum `<%- ... %>`.
- Tidak ada `console.log` debug di route — error masuk `errorHandler`.

## API internal

- `GET /api/classes` → proxy rapi ke backend
- `POST /api/booking` `{name,email,kelas,date?}` → validasi ketat
- `POST /api/contact` `{name,email,subject?,message,captcha?}` → teruskan ke backend
- `POST /api/newsletter` `{email}`

## Halaman & route

`/`, `/about`, `/classes`, `/classes/:slug`, `/pages/:slug`, `/instructors`,
`/blog`, `/blog/:slug`, `/packages`, `/packages/:slug`, `/event`,
`/gallery`, `/contact`
