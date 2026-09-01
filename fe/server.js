import "dotenv/config";
console.log("API_URL =", process.env.API_URL);
import express from "express";
import path from "path";
import { fileURLToPath } from "url";
import { yogaData } from "./data/yogaData.js";
import { getArticles, getArticle } from "./services/articleService.js";
import { getBanners } from "./services/bannerService.js";
import { getContactCaptcha, sendContact } from "./services/contactServices.js";
import { getTestimonials } from "./services/testimonialService.js";
import { getPage } from "./services/pageService.js";
import { getEvents } from "./services/eventService.js";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const app = express();
const PORT = process.env.PORT || 3000;

// View engine
app.set("view engine", "ejs");
app.set("views", path.join(__dirname, "views"));

// Middleware
app.use(express.static(path.join(__dirname, "public")));
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
app.get("/", async (req, res) => {
  try {
    const posts = await getArticles();
    const testimonials = await getTestimonials();

    res.render("pages/home", {
      title: "Yogaroots — Temukan Keseimbangan dalam Setiap Napas",
      hero: yogaData.hero,
      stats: yogaData.stats,
      features: yogaData.features,
      classes: yogaData.classes.slice(0, 6),
      pricing: yogaData.pricing,

      testimonials: testimonials.slice(0, 3),
      posts: posts.slice(0, 3),

    });
  } catch (error) {
    console.error("Gagal mengambil data api dari backend:", error);

    res.render("pages/home", {
      title: "Yogaroots — Temukan Keseimbangan dalam Setiap Napas",
      hero: yogaData.hero,
      stats: yogaData.stats,
      features: yogaData.features,
      classes: yogaData.classes.slice(0, 6),
      pricing: yogaData.pricing,
      
      testimonials: [],
      posts: [],
    });
  }
});

app.get("/classes", (req, res) => {
  const category = req.query.category || "all";
  let classes = yogaData.classes;
  if (category !== "all")
    classes = classes.filter((c) => c.category === category);
  res.render("pages/classes", {
    title: "Kelas Yoga — Temukan Aliranmu",
    classes,
    categories: yogaData.categories,
    activeCategory: category,
  });
});

app.get("/classes/:slug", (req, res) => {
  const cls = yogaData.classes.find((c) => c.slug === req.params.slug);
  if (!cls)
    return res
      .status(404)
      .render("pages/404", { title: "Kelas Tidak Ditemukan" });
  res.render("pages/class-detail", { title: cls.name, cls });
});

//pages

app.get("/pages/:slug", async (req, res, next) => {
  try {
    const page = await getPage(req.params.slug);

    res.render("pages/page-detail", {
      title: page.title,
      page,
    });
  } catch (error) {
    console.error("PAGE ERROR:", error);

    if (error.status === 404) {
      return next();
    }

    next(error);
  }
});

app.get("/schedule", (req, res) => {
  res.render("pages/schedule", {
    title: "Jadwal Mingguan",
    schedule: yogaData.schedule,
    days: ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"],
  });
});

app.get("/pricing", (req, res) => {
  res.render("pages/pricing", {
    title: "Paket & Harga",
    pricing: yogaData.pricing,
    faqs: yogaData.faqs,
  });
});

app.get("/instructors", (req, res) => {
  res.render("pages/instructors", {
    title: "Instruktur Kami",
    instructors: yogaData.instructors,
  });
});

//blog
app.get("/blog", async (req, res) => {
  try {
    const posts = await getArticles();

    res.render("pages/blog", {
      title: "Artikel & Tips Yoga",
      posts: posts.slice(0, 9),
      totalPosts: posts.length,
    });
  } catch (error) {
    console.error("Gagal mengambil artikel:", error);

    res.status(500).render("pages/blog", {
      title: "Artikel & Tips Yoga",
      posts: [],
      totalPosts: 0,
    });
  }
});

app.get("/blog/:slug", async (req, res) => {
  try {
    const post = await getArticle(req.params.slug);

    if (!post) {
      return res.status(404).render("pages/404", {
        title: "Artikel Tidak Ditemukan",
      });
    }

    res.render("pages/blog-detail", {
      title: post.title,
      post,
    });
  } catch (error) {
    console.error("Gagal mengambil detail artikel:", error);

    res.status(500).render("pages/404", {
      title: "Artikel Tidak Ditemukan",
    });
  }
});

// end blog

// events
app.get("/event", async (req, res) => {
    try {

        const params = {
            search: req.query.search || "",
            filter: req.query.filter || "",
            date_from: req.query.date_from || "",
            date_to: req.query.date_to || "",
        };


        console.log("FILTER REQUEST:", params);


        const response = await getEvents(params);


        const events = Array.isArray(response)
            ? response
            : Array.isArray(response?.data)
                ? response.data
                : [];


        console.log("EVENT RESULT:", events);


        res.render("pages/events", {

            title: "Event & Workshop",

            events: events,

            search: params.search,

            filter: params.filter,

            date_from: params.date_from,

            date_to: params.date_to,

            totalEvents: events.length,

            totalPages: 1,

            currentPage: 1,

            error: null,
        });


    } catch (error) {

        console.error("Gagal mengambil data event:", error);


        res.status(500).render("pages/events", {

            title: "Event & Workshop",

            events: [],

            search: req.query.search || "",

            filter: req.query.filter || "",

            date_from: req.query.date_from || "",

            date_to: req.query.date_to || "",

            totalEvents: 0,

            totalPages: 1,

            currentPage: 1,

            error: "Gagal mengambil data event.",
        });
    }
});

// end events

//gallery
app.get("/gallery", async (req, res) => {
  try {
    const gallery = await getBanners("galeri");

    console.log("GALLERY:", gallery);

    res.render("pages/gallery", {
      title: "Galeri Kami",
      gallery,
    });
  } catch (error) {
    console.error("Gagal mengambil galeri:", error);

    res.render("pages/gallery", {
      title: "Galeri Kami",
      gallery: [],
    });
  }
});

// end gallery

app.get("/contact", async (req, res) => {
  try {
    const captcha = await getContactCaptcha();

    console.log("CAPTCHA:", captcha);

    res.render("pages/contact", {
      title: "Hubungi Kami",
      contact: yogaData.contact,
      captcha,
    });
  } catch (error) {
    console.error("CONTACT ERROR:", error);

    res.render("pages/contact", {
      title: "Hubungi Kami",
      contact: yogaData.contact,
      captcha: null,
    });
  }
});

// API
app.get("/api/classes", (req, res) => res.json(yogaData.classes));
app.get("/api/schedule", (req, res) => res.json(yogaData.schedule));

app.post("/api/booking", (req, res) => {
  const { name, email, kelas, date } = req.body;
  if (!name || !email || !kelas) {
    return res
      .status(400)
      .json({ success: false, message: "Nama, email, dan kelas wajib diisi" });
  }
  console.log("[BOOKING]", {
    name,
    email,
    kelas,
    date,
    at: new Date().toISOString(),
  });
  res.json({
    success: true,
    message: `Terima kasih ${name}! Booking kelas ${kelas} berhasil. Kami kirim konfirmasi ke ${email}.`,
  });
});

app.post("/api/contact", async (req, res) => {
  try {
    console.log("[CONTACT REQUEST]", req.body);

    const result = await sendContact(req.body);

    console.log("[CONTACT RESPONSE]", result);

    return res.status(200).json({
      success: true,
      message: result.message || "Pesan berhasil dikirim.",
    });
  } catch (error) {
    console.error("[CONTACT ERROR]", error);

    return res.status(error.status || 500).json({
      success: false,
      message: error.message || "Gagal mengirim pesan.",
      errors: error.errors || null,
    });
  }
});

app.post("/api/newsletter", (req, res) => {
  const { email } = req.body;
  if (!email || !email.includes("@"))
    return res
      .status(400)
      .json({ success: false, message: "Email tidak valid" });
  res.json({
    success: true,
    message: "Selamat! Kamu terdaftar di newsletter kami.",
  });
});

// 404
app.use((req, res) => {
  res
    .status(404)
    .render("pages/404", { title: "Halaman Tidak Ditemukan — 404" });
});

app.listen(PORT, () => {
  console.log(`🧘 Yogaroots running at http://localhost:${PORT}`);
});
