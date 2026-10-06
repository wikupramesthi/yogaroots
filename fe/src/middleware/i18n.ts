import { translations } from "../data/translations.js";
import { env } from "../config/env.js";
import type { Request, Response, NextFunction } from "../types/index.js";

const SUPPORTED = ["en", "id", "ja", "ko", "zh"];
const ONE_YEAR = 365 * 24 * 60 * 60;

function parseCookies(req: Request): Record<string, string> {
  const cookies: Record<string, string> = {};
  const header = req.headers.cookie;
  if (header) {
    header.split(";").forEach((c: string) => {
      const [k, ...v] = c.trim().split("=");
      cookies[k] = decodeURIComponent(v.join("=") || "");
    });
  }
  return cookies;
}

/** Ganti bahasa via ?lang=en|id|ja|ko|zh lalu redirect bersih. Cookie HttpOnly + Secure (prod). */
export function i18n(req: Request, res: Response, next: NextFunction) {
  const langParam = typeof req.query.lang === "string" ? req.query.lang : "";
  if (langParam && SUPPORTED.includes(langParam)) {
    const flags = [
      `locale=${langParam}`,
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
