# 🪷 Serene — Tema Yoga Lengkap (Tailwind CSS v4 + EJS + Express)

Tema yoga premium, siap pakai untuk studio wellness, meditation & fitness. Dibuat dengan **Tailwind CSS v4**, **EJS**, **Express**. Responsive, estetik earthy, dan fitur lengkap.

![Serene Yoga](https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=1200&auto=format&fit=crop&q=60)

## ✨ Fitur Lengkap

| Fitur | Detail |
|-------|--------|
| **Desain** | Palette Sage + Terracotta + Cream, font Cormorant + Plus Jakarta Sans, rounded-3xl, glass-morphism |
| **Halaman** | Home, Kelas (filter kategori), Detail Kelas, Jadwal Mingguan, Harga (toggle bulanan/tahunan), Instruktur (6), Blog (6), Detail Blog, Galeri (lightbox), Kontak (maps+form), 404 |
| **Komponen** | Navbar sticky + hamburger, hero + stats, pricing 3 tier, FAQ accordion, testimonial, CTA, footer newsletter |
| **Interaksi** | Booking modal (POST /api/booking), contact form, newsletter, lightbox gallery, reveal on scroll |
| **Backend** | Express + EJS, data terpusat `data/yogaData.js`, API JSON `/api/classes` `/api/schedule` |
| **Styling** | Tailwind v4 `@theme` tokens, `input.css` → `output.css` via `@tailwindcss/cli` |

## 🚀 Cara Jalan

```bash
npm install
npm run build:css      # build sekali
# atau
npm run watch:css      # watch mode (terminal 1)
npm run dev            # server (terminal 2)
# atau sekaligus:
npm run dev:all        # butuh concurrently

# buka http://localhost:3000
```

## 📁 Struktur

```
yoga_theme/
├── server.js              # Express routes + API
├── data/yogaData.js       # Semua konten (kelas, jadwal, harga, dll) — edit di sini!
├── views/
│   ├── partials/ head.ejs, navbar.ejs, footer.ejs
│   └── pages/ home.ejs, classes.ejs, schedule.ejs, pricing.ejs, ...
├── public/
│   ├── css/input.css → output.css
│   └── js/main.js         # interaksi (modal, filter, lightbox, booking)
└── package.json
```

## 🎨 Kustomisasi Cepat

- **Warna**: edit `@theme` di `public/css/input.css`
- **Konten**: edit `data/yogaData.js` (tambah kelas, harga, post)
- **Gambar**: ganti URL Unsplash di data atau pakai `/public/images`

## 🔌 API

- `GET /api/classes` → JSON kelas
- `GET /api/schedule` → JSON jadwal
- `POST /api/booking` `{name,email,kelas,date}` → konfirmasi
- `POST /api/contact` `{name,email,message}`
- `POST /api/newsletter` `{email}`

## 📱 Halaman & Route

`/`, `/classes`, `/classes/:slug`, `/schedule`, `/pricing`, `/instructors`, `/blog`, `/blog/:slug`, `/gallery`, `/contact`

## 🧘 Filosofi

> "Yoga bukan tentang menyentuh jari kaki, tapi tentang apa yang kamu pelajari dalam perjalanan ke sana."

Dibuat dengan 🪷 di Jakarta — 2026
