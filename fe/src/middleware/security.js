import helmet from "helmet";
import rateLimit from "express-rate-limit";
import { env } from "../config/env.js";

/**
 * Security headers for EJS + Tailwind + Google Fonts theme.
 * - Loose CSP for img (backend storage + CMS) but strict for scripts.
 */
export function securityHeaders() {
  return helmet({
    contentSecurityPolicy: {
      // Full control (no helmet defaults) to avoid surprise directives.
      // upgrade-insecure-requests only in production (dev backend still http).
      useDefaults: false,
      directives: {
        defaultSrc: ["'self'"],
        baseUri: ["'self'"],
        frameAncestors: ["'none'"],
        objectSrc: ["'none'"],
        // Small inline <script> used by theme (dark-mode init, modal fallback)
        // + JSON event blob. 'unsafe-inline' accepted; no 'unsafe-eval'.
        scriptSrc: ["'self'", "'unsafe-inline'"],
        // Helmet separates attr handlers (onclick=...): modals/lightbox break without this
        scriptSrcAttr: ["'unsafe-inline'"],
        styleSrc: ["'self'", "'unsafe-inline'", "https://fonts.googleapis.com"],
        fontSrc: ["'self'", "https://fonts.gstatic.com"],
        // 'http:' REQUIRED for local backend (http://127.0.0.1:8000/storage/...)
        imgSrc: ["'self'", "data:", "https:", "http:"],
        connectSrc: ["'self'", env.API_URL],
        formAction: ["'self'"],
        ...(env.IS_PROD ? { upgradeInsecureRequests: [] } : {}),
      },
    },
    crossOriginEmbedderPolicy: false, // cross-origin CMS images
    referrerPolicy: { policy: "strict-origin-when-cross-origin" },
  });
}

/** General rate limit for write endpoints (anti spam bots). */
export function writeLimiter() {
  return rateLimit({
    windowMs: 60 * 1000,
    max: 20,
    standardHeaders: "draft-7",
    legacyHeaders: false,
    message: { success: false, message: "Too many requests, please try again shortly." },
  });
}

/** Reject cross-origin POSTs (simple CSRF for JSON fetch). */
export function sameOriginOnly(req, res, next) {
  const origin = req.get("origin");
  if (origin && req.method !== "GET" && req.method !== "HEAD") {
    try {
      const expectedHost = req.get("host");
      const originHost = new URL(origin).host;
      if (originHost !== expectedHost) {
        return res.status(403).json({ success: false, message: "Origin not allowed." });
      }
    } catch {
      return res.status(403).json({ success: false, message: "Invalid origin." });
    }
  }
  next();
}
