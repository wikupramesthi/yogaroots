import express from 'express';
import path from 'path';
import { fileURLToPath } from 'url';
import { yogaData } from './data/yogaData.js';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const app = express();
const PORT = process.env.PORT || 3000;

// View engine
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

// Middleware
app.use(express.static(path.join(__dirname, 'public')));
app.use(express.urlencoded({ extended: true }));
app.use(express.json());

// Inject global data to all views
app.use((req, res, next) => {
  res.locals.site = yogaData.site;
  res.locals.nav = yogaData.nav;
  res.locals.currentPath = req.path;
  next();
});

// Routes
app.get('/', (req, res) => {
  res.render('pages/home', {
    title: 'Serene — Temukan Keseimbangan dalam Setiap Napas',
    hero: yogaData.hero,
    stats: yogaData.stats,
    features: yogaData.features,
    classes: yogaData.classes.slice(0, 6),
    instructors: yogaData.instructors.slice(0, 3),
    testimonials: yogaData.testimonials,
    pricing: yogaData.pricing
  });
});

app.get('/classes', (req, res) => {
  const category = req.query.category || 'all';
  let classes = yogaData.classes;
  if (category !== 'all') classes = classes.filter(c => c.category === category);
  res.render('pages/classes', {
    title: 'Kelas Yoga — Temukan Aliranmu',
    classes,
    categories: yogaData.categories,
    activeCategory: category
  });
});

app.get('/classes/:slug', (req, res) => {
  const cls = yogaData.classes.find(c => c.slug === req.params.slug);
  if (!cls) return res.status(404).render('pages/404', { title: 'Kelas Tidak Ditemukan' });
  res.render('pages/class-detail', { title: cls.name, cls });
});

app.get('/schedule', (req, res) => {
  res.render('pages/schedule', {
    title: 'Jadwal Mingguan',
    schedule: yogaData.schedule,
    days: ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu']
  });
});

app.get('/pricing', (req, res) => {
  res.render('pages/pricing', {
    title: 'Paket & Harga',
    pricing: yogaData.pricing,
    faqs: yogaData.faqs
  });
});

app.get('/instructors', (req, res) => {
  res.render('pages/instructors', {
    title: 'Instruktur Kami',
    instructors: yogaData.instructors
  });
});

app.get('/blog', (req, res) => {
  res.render('pages/blog', {
    title: 'Jurnal Mindfulness',
    posts: yogaData.posts
  });
});

app.get('/blog/:slug', (req, res) => {
  const post = yogaData.posts.find(p => p.slug === req.params.slug);
  if (!post) return res.status(404).render('pages/404', { title: 'Artikel Tidak Ditemukan' });
  res.render('pages/blog-detail', { title: post.title, post });
});

app.get('/gallery', (req, res) => {
  res.render('pages/gallery', {
    title: 'Galeri Serene',
    gallery: yogaData.gallery
  });
});

app.get('/contact', (req, res) => {
  res.render('pages/contact', {
    title: 'Hubungi Kami',
    contact: yogaData.contact
  });
});

// API
app.get('/api/classes', (req, res) => res.json(yogaData.classes));
app.get('/api/schedule', (req, res) => res.json(yogaData.schedule));

app.post('/api/booking', (req, res) => {
  const { name, email, kelas, date } = req.body;
  if (!name || !email || !kelas) {
    return res.status(400).json({ success: false, message: 'Nama, email, dan kelas wajib diisi' });
  }
  console.log('[BOOKING]', { name, email, kelas, date, at: new Date().toISOString() });
  res.json({ success: true, message: `Terima kasih ${name}! Booking kelas ${kelas} berhasil. Kami kirim konfirmasi ke ${email}.` });
});

app.post('/api/contact', (req, res) => {
  const { name, email, message } = req.body;
  if (!name || !email || !message) {
    return res.status(400).json({ success: false, message: 'Semua field wajib diisi' });
  }
  console.log('[CONTACT]', { name, email, message });
  res.json({ success: true, message: 'Pesan terkirim! Kami akan membalas dalam 24 jam.' });
});

app.post('/api/newsletter', (req, res) => {
  const { email } = req.body;
  if (!email || !email.includes('@')) return res.status(400).json({ success:false, message:'Email tidak valid'});
  res.json({ success:true, message:'Selamat! Kamu terdaftar di newsletter Serene.'});
});

// 404
app.use((req, res) => {
  res.status(404).render('pages/404', { title: 'Halaman Tidak Ditemukan — 404' });
});

app.listen(PORT, () => {
  console.log(`🧘 Serene Yoga running at http://localhost:${PORT}`);
});
