import "dotenv/config";
console.log("API_URL =", process.env.API_URL);
import express from "express";
import path from "path";
import { fileURLToPath } from "url";
import { yogaData } from "./data/yogaData.js";
import { translations } from "./data/translations.js";

function parseCookies(req) {
  const cookies = {};
  const header = req.headers.cookie;
  if (header) {
    header.split(";").forEach((c) => {
      const [k, ...v] = c.trim().split("=");
      cookies[k] = decodeURIComponent(v.join("=") || "");
    });
  }
  return cookies;
}
import { getArticles, getArticle } from "./services/articleService.js";
import { getBanners } from "./services/bannerService.js";
import { getContactCaptcha, sendContact } from "./services/contactServices.js";
import { getTestimonials } from "./services/testimonialService.js";
import { getPage } from "./services/pageService.js";
import { getEvents } from "./services/eventService.js";
import { getClasses, getClass } from "./services/classService.js";
import { getInstructors } from "./services/instructorService.js";
import { getFaqs } from "./services/faqService.js";
import { getPackages, getPackage } from "./services/packageService.js";

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
  res.locals.currentUrl = `${req.protocol}://${req.get("host")}${req.path}`;
  next();
});

// i18n middleware
app.use((req, res, next) => {
  // Language switch via query param: ?lang=en or ?lang=id
  if (req.query.lang && ["en", "id"].includes(req.query.lang)) {
    res.setHeader(
      "Set-Cookie",
      `locale=${req.query.lang}; Path=/; Max-Age=${365 * 24 * 60 * 60}; SameSite=Lax`
    );
    const url = new URL(
      req.originalUrl,
      `${req.protocol}://${req.get("host")}`
    );
    url.searchParams.delete("lang");
    return res.redirect(url.pathname + url.search);
  }

  const cookies = parseCookies(req);
  const lang = cookies.locale || "en";
  res.locals.lang = lang;
  res.locals.t = translations[lang] || translations.en;
  next();
});

// Routes
app.get("/", async (req, res) => {
  try {
    const testimonials = await getTestimonials();

    const classes = await getClasses({
      per_page: 6,
    });

    const packages = await getPackages({
      per_page: 3,
    });

    const events = await getEvents({
      per_page: 3,
    });

    console.dir(packages, {
      depth: null,
    });

    res.render("pages/home", {
      title: "YogaRoots — Find Balance in Every Breath",

      hero: yogaData.hero,
      stats: yogaData.stats,
      features: yogaData.features,

      classes: classes.data || classes,
      packages: packages || [],
      events: Array.isArray(events) ? events : events?.data || [],

      testimonials: testimonials.slice(0, 3),
    });
  } catch (error) {
    console.error("Gagal mengambil data API dari backend:", error);

    res.render("pages/home", {
      title: "YogaRoots — Find Balance in Every Breath",

      hero: yogaData.hero,
      stats: yogaData.stats,
      features: yogaData.features,

      classes: [],
      packages: [],
      events: [],
      testimonials: [],
    });
  }
});

// about
app.get("/about", (req, res) => {
  res.render("pages/about", {
    title: "About YogaRoots — Our Story & Practice",
  });
});

// classes
app.get("/classes", (req, res) => {
  res.render("pages/classes", {
    title: "YogaRoots — Yoga Classes for All Levels",
  });
});

app.get("/classes/:slug", async (req, res) => {
  try {
    const cls = await getClass(req.params.slug);

    if (!cls) {
      return res.status(404).render("pages/404", {
        title: "Kelas Tidak Ditemukan",
      });
    }

    res.render("pages/class-detail", {
      title: cls.name,
      cls,
    });
  } catch (error) {
    console.error("Gagal mengambil detail class:", error);

    return res.status(error.status || 500).render("pages/404", {
      title:
        error.status === 404 ? "Kelas Tidak Ditemukan" : "Gagal Memuat Class",
    });
  }
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

app.get("/instructors", async (req, res) => {
  try {
    const instructors = await getInstructors({
      per_page: 20,
    });

    res.render("pages/instructors", {
      title: "Our Instructors — YogaRoots",
      instructors,
    });
  } catch (error) {
    console.error("Gagal mengambil data instruktur:", error);

    res.status(error.status || 500).render("pages/404", {
      title: "Instructors Not Found",
    });
  }
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

// packages

app.get("/packages", async (req, res) => {
  try {
    const params = {
      search: req.query.search || "",
      filter: req.query.filter || "",
      sort: req.query.sort || "",
      page: Number(req.query.page) || 1,
      per_page: 10,
    };

    console.log("PACKAGE PARAMS:", params);

    const response = await getPackages(params);

    console.log("PACKAGE API RESPONSE:", response);

    // getPackages() sudah mengembalikan array package
    const packages = Array.isArray(response) ? response : [];

    console.log("PACKAGE COUNT:", packages.length);

    return res.render("pages/packages", {
      title: "Membership Packages",

      packages,

      search: params.search,
      filter: params.filter,
      sort: params.sort,

      totalPackages: packages.length,
      currentPage: params.page,
      totalPages: 1,

      error: null,
    });
  } catch (error) {
    console.error("PACKAGE ERROR:", error);

    return res.status(500).render("pages/packages", {
      title: "Membership Packages",

      packages: [],

      search: req.query.search || "",
      filter: req.query.filter || "",
      sort: req.query.sort || "",

      totalPackages: 0,
      currentPage: 1,
      totalPages: 1,

      error: "Gagal mengambil data package.",
    });
  }
});

app.get("/packages/:slug", async (req, res) => {
  try {
    const packageDetail = await getPackage(req.params.slug);

    return res.render("pages/packages-detail", {
      title: packageDetail.name,
      package: packageDetail,
      error: null,
    });
  } catch (error) {
    console.error("PACKAGE DETAIL ERROR:", error);

    return res.status(404).render("pages/packages-detail", {
      title: "Package Not Found",
      package: null,
      error: "Package tidak ditemukan.",
    });
  }
});

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
  let captcha = null;
  let faqs = [];

  try {
    const captchaResponse = await getContactCaptcha();
    captcha = captchaResponse?.data || captchaResponse;
  } catch (error) {
    console.error("CAPTCHA ERROR:", error);
  }

  try {
    const faqResponse = await getFaqs();

    faqs = Array.isArray(faqResponse) ? faqResponse : faqResponse?.data || [];
  } catch (error) {
    console.error("FAQ ERROR:", error);
  }

  res.render("pages/contact", {
    title: "Contact Us",
    contact: yogaData.contact,
    captcha,
    faqs,
  });
});

// API
app.get("/api/classes", (req, res) => res.json(yogaData.classes));

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
