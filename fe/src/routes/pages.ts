import { Router } from "express";
import { yogaData } from "../data/yogaData.js";
import { getTestimonials } from "../services/testimonialService.js";
import { getArticles, getArticle } from "../services/articleService.js";
import { getBanners } from "../services/bannerService.js";
import { getContactCaptcha } from "../services/contactService.js";
import { getEvents } from "../services/eventService.js";
import { getClasses, getClass } from "../services/classService.js";
import { getInstructors } from "../services/instructorService.js";
import { getFaqs } from "../services/faqService.js";
import { getPackages, getPackage } from "../services/packageService.js";
import { getSiteStats, formatStatCount } from "../services/siteStatsService.js";
import { getPage } from "../services/pageService.js";
import { cleanSlug, cleanText, cleanPage, cleanDate } from "../utils/validate.js";
import { sanitizeRichHtml } from "../utils/sanitize.js";
import type { Request, Response, NextFunction } from "../types/index.js";

const router = Router();

// ---------- Home ----------
router.get("/", async (req: Request, res: Response, next: NextFunction) => {
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
router.get("/about", async (req: Request, res: Response, next: NextFunction) => {
  try {
    const [stats, posts] = await Promise.all([
      getSiteStats().catch(() => null),
      getArticles(res.locals.lang).then((r) => (Array.isArray(r) ? r.slice(0, 3) : [])).catch(() => []),
    ]);
    res.render("pages/about", {
      title: "About YogaRoots — Our Story & Practice",
      liveStats: stats,
      formatStat: (v) => formatStatCount(v, res.locals.lang),
      posts,
    });
  } catch (err) {
    next(err);
  }
});

router.get("/classes", async (req: Request, res: Response, next: NextFunction) => {
  try {
    const response = await getClasses({ per_page: 50 }).catch(() => []);
    const classes = Array.isArray(response) ? response : response?.data || [];
    res.render("pages/classes", {
      title: "YogaRoots — Class Guide",
      metaDescription: res.locals.t.classGuideDesc,
      classes,
    });
  } catch (err) {
    next(err);
  }
});

// ---------- Schedules (weekly timetable) ----------
router.get("/schedules", (req: Request, res: Response) => {
  res.render("pages/schedules", {
    title: "YogaRoots — Class Schedules",
    metaDescription: res.locals.t.classesDesc,
  });
});

// ---------- Art of Living (Gurudev) ----------
router.get("/art-of-living", (req: Request, res: Response) => {
  const isID = res.locals.lang === "id";
  res.render("pages/art-of-living", {
    title: isID
      ? "Art of Living — Gurudev Sri Sri Ravi Shankar | YogaRoots"
      : "Art of Living — Gurudev Sri Sri Ravi Shankar | YogaRoots",
    metaDescription: isID
      ? "Mengenal Gurudev Sri Sri Ravi Shankar, pendiri Art of Living — duta perdamaian, pencipta Sudarshan Kriya, menjangkau 800 juta+ jiwa di 180 negara."
      : "Meet Gurudev Sri Sri Ravi Shankar, founder of Art of Living — ambassador of peace, creator of Sudarshan Kriya, reaching 800M+ lives across 180 countries.",
    heroNav: true,
  });
});

// ---------- Class detail ----------
router.get("/classes/:slug", async (req: Request, res: Response, next: NextFunction) => {
  try {
    const cls = await getClass(cleanSlug(req.params.slug, "class"));
    if (!cls) return res.status(404).render("pages/404", { title: "Class Not Found", robots: "noindex, nofollow", heroNav: true });
    res.render("pages/class-detail", { title: cls.name, cls });
  } catch (err) {
    if (err.status === 404 || err.status === 400) {
      return res.status(404).render("pages/404", { title: "Class Not Found", robots: "noindex, nofollow", heroNav: true });
    }
    next(err);
  }
});

// ---------- CMS page ----------
router.get("/pages/:slug", async (req: Request, res: Response, next: NextFunction) => {
  try {
    const page = await getPage(cleanSlug(req.params.slug, "page"));
    res.render("pages/page-detail", {
      title: page.title,
      page: { ...page, content: sanitizeRichHtml(page.content) },
    });
  } catch (err) {
    next(err.status === 404 ? Object.assign(new Error("Page not found"), { status: 404 }) : err);
  }
});

// ---------- Instructors ----------
router.get("/instructors", async (req: Request, res: Response, next: NextFunction) => {
  try {
    const instructors = await getInstructors({ per_page: 20 });
    res.render("pages/instructors", { title: "Our Instructors — YogaRoots", instructors });
  } catch (err) {
    next(err);
  }
});

// ---------- Blog ----------
router.get("/blog", async (req: Request, res: Response, next: NextFunction) => {
  try {
    const posts = await getArticles(res.locals.lang);
    res.render("pages/blog", {
      title: "Yoga Articles & Tips",
      posts: posts.slice(0, 9),
      totalPosts: posts.length,
    });
  } catch (err) {
    next(err);
  }
});

router.get("/blog/:slug", async (req: Request, res: Response, next: NextFunction) => {
  try {
    const slug = cleanSlug(req.params.slug, "article");
    const [post, all] = await Promise.all([
      getArticle(slug, res.locals.lang),
      getArticles(res.locals.lang).catch(() => []),
    ]);
    if (!post) return res.status(404).render("pages/404", { title: "Article Not Found", robots: "noindex, nofollow", heroNav: true });
    const others = (Array.isArray(all) ? all : []).filter((a) => a.slug && a.slug !== post.slug);
    const related = [
      ...others.filter((a) => post.category && a.category === post.category),
      ...others.filter((a) => !post.category || a.category !== post.category),
    ].slice(0, 3);
    const latestClasses = await getClasses({ per_page: 3 }).then((r) => {
      const list = Array.isArray(r) ? r : r?.data || [];
      return list.slice(0, 3);
    }).catch(() => []);
    res.render("pages/blog-detail", {
      title: post.title,
      post: { ...post, content: sanitizeRichHtml(post.content) },
      related,
      latestClasses,
    });
  } catch (err) {
    if (err.status === 404 || err.status === 400) {
      return res.status(404).render("pages/404", { title: "Article Not Found", robots: "noindex, nofollow", heroNav: true });
    }
    next(err);
  }
});

// ---------- Packages ----------
router.get("/packages", async (req: Request, res: Response, next: NextFunction) => {
  try {
    const params = {
      search: cleanText(req.query.search, { max: 80, label: "Search" }),
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

router.get("/packages/:slug", async (req: Request, res: Response) => {
  try {
    const packageDetail = await getPackage(cleanSlug(req.params.slug, "package"));
    res.render("pages/packages-detail", {
      title: packageDetail.name,
      package: packageDetail,
      error: null,
    });
  } catch (err) {
    return res.status(404).render("pages/packages-detail", {
      title: "Package Not Found",
      package: null,
      error: "Package not found.",
    });
  }
});

// ---------- Events ----------
router.get("/event", async (req: Request, res: Response, next: NextFunction) => {
  try {
    const params = {
      search: cleanText(req.query.search, { max: 80, label: "Search" }),
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

// ---------- Gallery (hanya foto asli API; tanpa placeholder) ----------
router.get("/gallery", async (req: Request, res: Response, next: NextFunction) => {
  try {
    const response = await getBanners("galeri").catch(() => []);
    const list = Array.isArray(response) ? response : response?.data || [];
    const gallery = list.filter((g) => g && g.gambar && !String(g.gambar).includes("default.png"));
    res.render("pages/gallery", { title: "Our Gallery", gallery });
  } catch (err) {
    next(err);
  }
});

// ---------- Contact ----------
router.get("/contact", async (req: Request, res: Response) => {
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
