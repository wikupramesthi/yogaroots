import { Router } from "express";
import { yogaData } from "../../data/yogaData.js";
import { getTestimonials } from "../../services/testimonialService.js";
import { getArticles, getArticle } from "../../services/articleService.js";
import { getBanners } from "../../services/bannerService.js";
import { getContactCaptcha } from "../../services/contactService.js";
import { getEvents } from "../../services/eventService.js";
import { getClasses, getClass } from "../../services/classService.js";
import { getInstructors } from "../../services/instructorService.js";
import { getFaqs } from "../../services/faqService.js";
import { getPackages, getPackage } from "../../services/packageService.js";
import { getPage } from "../../services/pageService.js";
import { cleanSlug, cleanText, cleanPage, cleanDate } from "../utils/validate.js";
import { sanitizeRichHtml } from "../utils/sanitize.js";

const router = Router();

// ---------- Home ----------
router.get("/", async (req, res, next) => {
  try {
    const [testimonials, classes, packages, events] = await Promise.all([
      getTestimonials().catch(() => []),
      getClasses({ per_page: 6 }).catch(() => []),
      getPackages({ per_page: 3 }).catch(() => []),
      getEvents({ per_page: 3 }).catch(() => []),
    ]);

    res.render("pages/home", {
      title: "YogaRoots — Find Balance in Every Breath",
      classes: classes?.data || classes || [],
      packages: packages || [],
      events: Array.isArray(events) ? events : events?.data || [],
      testimonials: Array.isArray(testimonials) ? testimonials.slice(0, 3) : [],
    });
  } catch (err) {
    next(err);
  }
});

// ---------- Static ----------
router.get("/about", (req, res) => {
  res.render("pages/about", { title: "About YogaRoots — Our Story & Practice" });
});

router.get("/classes", (req, res) => {
  res.render("pages/classes", { title: "YogaRoots — Yoga Classes for All Levels" });
});

// ---------- Class detail ----------
router.get("/classes/:slug", async (req, res, next) => {
  try {
    const cls = await getClass(cleanSlug(req.params.slug, "kelas"));
    if (!cls) return res.status(404).render("pages/404", { title: "Kelas Tidak Ditemukan" });
    res.render("pages/class-detail", { title: cls.name, cls });
  } catch (err) {
    if (err.status === 404 || err.status === 400) {
      return res.status(404).render("pages/404", { title: "Kelas Tidak Ditemukan" });
    }
    next(err);
  }
});

// ---------- CMS page ----------
router.get("/pages/:slug", async (req, res, next) => {
  try {
    const page = await getPage(cleanSlug(req.params.slug, "halaman"));
    res.render("pages/page-detail", {
      title: page.title,
      page: { ...page, content: sanitizeRichHtml(page.content) },
    });
  } catch (err) {
    next(err.status === 404 ? Object.assign(new Error("Halaman tidak ditemukan"), { status: 404 }) : err);
  }
});

// ---------- Instructors ----------
router.get("/instructors", async (req, res, next) => {
  try {
    const instructors = await getInstructors({ per_page: 20 });
    res.render("pages/instructors", { title: "Our Instructors — YogaRoots", instructors });
  } catch (err) {
    next(err);
  }
});

// ---------- Blog ----------
router.get("/blog", async (req, res, next) => {
  try {
    const posts = await getArticles(res.locals.lang);
    res.render("pages/blog", {
      title: "Artikel & Tips Yoga",
      posts: posts.slice(0, 9),
      totalPosts: posts.length,
    });
  } catch (err) {
    next(err);
  }
});

router.get("/blog/:slug", async (req, res, next) => {
  try {
    const post = await getArticle(cleanSlug(req.params.slug, "artikel"), res.locals.lang);
    if (!post) return res.status(404).render("pages/404", { title: "Artikel Tidak Ditemukan" });
    res.render("pages/blog-detail", {
      title: post.title,
      post: { ...post, content: sanitizeRichHtml(post.content) },
    });
  } catch (err) {
    if (err.status === 404 || err.status === 400) {
      return res.status(404).render("pages/404", { title: "Artikel Tidak Ditemukan" });
    }
    next(err);
  }
});

// ---------- Packages ----------
router.get("/packages", async (req, res, next) => {
  try {
    const params = {
      search: cleanText(req.query.search, { max: 80, label: "Pencarian" }),
      filter: cleanText(req.query.filter, { max: 40, label: "Filter" }),
      sort: cleanText(req.query.sort, { max: 40, label: "Sort" }),
      page: cleanPage(req.query.page),
      per_page: 10,
    };
    const response = await getPackages(params);
    const packages = Array.isArray(response) ? response : [];
    res.render("pages/packages", {
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
  } catch (err) {
    next(err);
  }
});

router.get("/packages/:slug", async (req, res) => {
  try {
    const packageDetail = await getPackage(cleanSlug(req.params.slug, "paket"));
    res.render("pages/packages-detail", {
      title: packageDetail.name,
      package: packageDetail,
      error: null,
    });
  } catch (err) {
    return res.status(404).render("pages/packages-detail", {
      title: "Package Not Found",
      package: null,
      error: "Package tidak ditemukan.",
    });
  }
});

// ---------- Events ----------
router.get("/event", async (req, res, next) => {
  try {
    const params = {
      search: cleanText(req.query.search, { max: 80, label: "Pencarian" }),
      filter: cleanText(req.query.filter, { max: 40, label: "Filter" }),
      date_from: req.query.date_from ? cleanDate(req.query.date_from) : "",
      date_to: req.query.date_to ? cleanDate(req.query.date_to) : "",
    };
    const response = await getEvents(params);
    const events = Array.isArray(response) ? response : response?.data || [];
    res.render("pages/events", {
      title: "Event & Workshop",
      events,
      ...params,
      totalEvents: events.length,
      totalPages: 1,
      currentPage: 1,
      error: null,
    });
  } catch (err) {
    next(err);
  }
});

// ---------- Gallery ----------
router.get("/gallery", async (req, res, next) => {
  try {
    const gallery = await getBanners("galeri");
    res.render("pages/gallery", { title: "Galeri Kami", gallery });
  } catch (err) {
    next(err);
  }
});

// ---------- Contact ----------
router.get("/contact", async (req, res) => {
  const [captcha, faqs] = await Promise.all([
    getContactCaptcha().then((r) => r?.data ?? r).catch(() => null),
    getFaqs().then((r) => (Array.isArray(r) ? r : r?.data || [])).catch(() => []),
  ]);
  res.render("pages/contact", {
    title: "Contact Us",
    contact: yogaData.contact,
    captcha,
    faqs,
  });
});

export default router;
