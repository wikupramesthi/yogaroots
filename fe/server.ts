/**
 * YogaRoots FE — thin bootstrap.
 * Route/middleware/config tinggal di src/ agar server.js tetap ramping:
 *
 *   src/config/env.ts          env tervalidasi (API_URL, SITE_URL, WA, OAuth)
 *   src/middleware/security.ts helmet CSP + rate limit + origin check
 *   src/middleware/locals.ts   site/nav/contactLinks/currentUrl aman
 *   src/middleware/i18n.ts     ?lang=en|id|ja|ko|zh + cookie HttpOnly
 *   src/middleware/minify.ts   HTML minify (view-source ringkas)
 *   src/middleware/errors.ts   404 + error handler
 *   src/routes/pages.ts        semua GET halaman
 *   src/routes/api.ts          /api/* (validasi + limit)
 *   src/routes/sitemap.ts      /sitemap.xml dinamis + /robots.txt
 *   src/utils/validate.ts      validasi input
 *   src/utils/sanitize.ts      sanitasi HTML CMS
 */
import express from "express";
import compression from "compression";
import path from "path";
import { fileURLToPath } from "url";
import { env } from "./src/config/env.js";
import { securityHeaders, writeLimiter, sameOriginOnly } from "./src/middleware/security.js";
import { appLocals } from "./src/middleware/locals.js";
import { i18n } from "./src/middleware/i18n.js";
import { minifyHtml } from "./src/middleware/minify.js";
import { notFound, errorHandler } from "./src/middleware/errors.js";
import pageRoutes from "./src/routes/pages.js";
import apiRoutes from "./src/routes/api.js";
import sitemapRoutes from "./src/routes/sitemap.js";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const app = express();
app.disable("x-powered-by");
app.set("trust proxy", false); // host header tidak dipercaya untuk URL publik

// View engine
app.set("view engine", "ejs");
app.set("views", path.join(__dirname, "views"));

// Security + kompresi + parsing
app.use(securityHeaders());
app.use(compression());
app.use(
  express.static(path.join(__dirname, "public"), {
    // CSS/JS sudah cache-busting (?v=ASSET_V): cache lama + immutable.
    // Gambar tanpa versi: 7 hari agar update logo tidak nyangkut lama.
    maxAge: "7d",
    setHeaders: (res, filePath) => {
      if (/\.(css|js)$/i.test(filePath)) {
        res.setHeader("Cache-Control", "public, max-age=31536000, immutable");
      }
    },
  }),
);
app.use(express.urlencoded({ extended: true, limit: "100kb" }));
app.use(express.json({ limit: "100kb" }));

// Context global views + bahasa + HTML minify (view-source ringkas)
app.use(appLocals);
app.use(i18n);
app.use(minifyHtml());

// Sitemap XML dinamis + robots.txt (sebelum halaman, tanpa minify HTML)
app.use("/", sitemapRoutes);

// Halaman
app.use("/", pageRoutes);

// API internal (rate-limit + tolak lintas origin)
app.use("/api", writeLimiter(), sameOriginOnly, apiRoutes);

// 404 + error handler (paling akhir)
app.use(notFound);
app.use(errorHandler);

app.listen(env.PORT, () => {
  console.log(`🧘 YogaRoots FE running at http://localhost:${env.PORT} (API: ${env.API_URL})`);
});
