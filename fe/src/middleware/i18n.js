import { translations } from "../data/translations.js";
import { env } from "../config/env.js";

const SUPPORTED = ["en", "id", "ja", "ko", "zh"];
const ONE_YEAR = 365 * 24 * 60 * 60;

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

/** Ganti bahasa via ?lang=en|id|ja|ko|zh lalu redirect bersih. Cookie HttpOnly + Secure (prod). */
export function i18n(req, res, next) {
  if (req.query.lang && SUPPORTED.includes(req.query.lang)) {
    const flags = [
      `locale=${req.query.lang}`,
      "Path=/",
      `Max-Age=${ONE_YEAR}`,
      "SameSite=Lax",
      "HttpOnly",
      ...(env.IS_PROD ? ["Secure"] : []),
    ];
    res.setHeader("Set-Cookie", flags.join("; "));
    const url = new URL(req.originalUrl, `${req.protocol}://${req.get("host")}`);
    url.searchParams.delete("lang");
    return res.redirect(url.pathname + url.search);
  }

  const cookies = parseCookies(req);
  const lang = SUPPORTED.includes(cookies.locale) ? cookies.locale : "en";
  res.locals.lang = lang;
  res.locals.t = translations[lang] || translations.en;
  next();
}
