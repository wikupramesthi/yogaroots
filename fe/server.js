/**
 * YogaRoots FE — thin bootstrap.
 * Route/middleware/config tinggal di src/ agar server.js tetap ramping:
 *
 *   src/config/env.js          env tervalidasi (API_URL, SITE_URL, WA, OAuth)
 *   src/middleware/security.js helmet CSP + rate limit + origin check
 *   src/middleware/locals.js   site/nav/contactLinks/currentUrl aman
 *   src/middleware/i18n.js     ?lang=en|id|ja|ko|zh + cookie HttpOnly
 *   src/middleware/errors.js   404 + error handler
 *   src/routes/pages.js        semua GET halaman
 *   src/routes/api.js          /api/* (validasi + limit)
 *   src/utils/validate.js      validasi input
 *   src/utils/sanitize.js      sanitasi HTML CMS
 */
import express from "express";
import path from "path";
import { fileURLToPath } from "url";
import { env } from "./src/config/env.js";
import { securityHeaders, writeLimiter, sameOriginOnly } from "./src/middleware/security.js";
import { appLocals } from "./src/middleware/locals.js";
import { i18n } from "./src/middleware/i18n.js";
import { notFound, errorHandler } from "./src/middleware/errors.js";
import pageRoutes from "./src/routes/pages.js";
import apiRoutes from "./src/routes/api.js";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const app = express();
app.disable("x-powered-by");
app.set("trust proxy", false); // host header tidak dipercaya untuk URL publik

// View engine
app.set("view engine", "ejs");
app.set("views", path.join(__dirname, "views"));

// Security + parsing
app.use(securityHeaders());
app.use(express.static(path.join(__dirname, "public")));
app.use(express.urlencoded({ extended: true, limit: "100kb" }));
app.use(express.json({ limit: "100kb" }));

// Context global views + bahasa
app.use(appLocals);
app.use(i18n);

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
