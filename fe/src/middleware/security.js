import helmet from "helmet";
import rateLimit from "express-rate-limit";
import { env } from "../config/env.js";

/**
 * Security headers untuk theme EJS + Tailwind + Google Fonts.
 * - CSP longgar untuk img (backend storage + CMS) tapi ketat untuk script.
 */
export function securityHeaders() {
  return helmet({
    contentSecurityPolicy: {
      // Kontrol penuh (tanpa default helmet) agar tidak ada direktif kejutan.
      // upgrade-insecure-requests hanya di production (backend dev masih http).
      useDefaults: false,
      directives: {
        defaultSrc: ["'self'"],
        baseUri: ["'self'"],
        frameAncestors: ["'none'"],
        objectSrc: ["'none'"],
        // Inline <script> kecil dipakai theme (dark-mode init, modal fallback)
        // + JSON blob event. 'unsafe-inline' diterima; tanpa 'unsafe-eval'.
        scriptSrc: ["'self'", "'unsafe-inline'"],
        // Helmet memisahkan attr handler (onclick=...): tanpa ini modal/lightbox mati
        scriptSrcAttr: ["'unsafe-inline'"],
        styleSrc: ["'self'", "'unsafe-inline'", "https://fonts.googleapis.com"],
        fontSrc: ["'self'", "https://fonts.gstatic.com"],
        // 'http:' WAJIB untuk backend lokal (http://127.0.0.1:8000/storage/...)
        imgSrc: ["'self'", "data:", "https:", "http:"],
        connectSrc: ["'self'", env.API_URL],
        formAction: ["'self'"],
        ...(env.IS_PROD ? { upgradeInsecureRequests: [] } : {}),
      },
    },
    crossOriginEmbedderPolicy: false, // gambar CMS lintas origin
    referrerPolicy: { policy: "strict-origin-when-cross-origin" },
  });
}

/** Rate limit umum untuk endpoint tulis (anti spam bot). */
export function writeLimiter() {
  return rateLimit({
    windowMs: 60 * 1000,
    max: 20,
    standardHeaders: "draft-7",
    legacyHeaders: false,
    message: { success: false, message: "Terlalu banyak permintaan, coba lagi sebentar." },
  });
}

/** Tolak POST lintas origin (CSRF sederhana untuk fetch JSON). */
export function sameOriginOnly(req, res, next) {
  const origin = req.get("origin");
  if (origin && req.method !== "GET" && req.method !== "HEAD") {
    try {
      const expectedHost = req.get("host");
      const originHost = new URL(origin).host;
      if (originHost !== expectedHost) {
        return res.status(403).json({ success: false, message: "Origin tidak diizinkan." });
      }
    } catch {
      return res.status(403).json({ success: false, message: "Origin tidak valid." });
    }
  }
  next();
}
