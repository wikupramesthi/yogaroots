import { yogaData } from "../data/yogaData.js";
import { siteContact, env } from "../config/env.js";
import { resolveSite } from "../services/siteIdentityService.js";
import type { Request, Response, NextFunction, SiteIdentity } from "../types/index.js";

/**
 * Data global untuk semua views: site (dinamis dari API identitas),
 * nav, URL aman, kontak terpusat, dan default SEO.
 * Mencegah host-header injection: canonical dibangun dari SITE_URL + path,
 * bukan dari header Host mentah.
 */
export async function appLocals(req: Request, res: Response, next: NextFunction) {
  try {
    // Identitas dinamis (cache 10 mnt di service, fallback statis bila BE mati).
    const site: SiteIdentity = await resolveSite();

    res.locals.site = site;
    res.locals.nav = yogaData.nav;
    res.locals.contactLinks = siteContact;
    res.locals.currentPath = req.path;
    res.locals.currentUrl = `${env.SITE_URL}${req.path}`;
    res.locals.siteUrl = env.SITE_URL;
    // Versi asset untuk cache-busting (?v=) — via env ASSET_V
    res.locals.assetV = env.ASSET_V;
    // `title` default — setiap halaman boleh override via render()
    if (res.locals.title === undefined) {
      res.locals.title = site.metaTitle || `${site.name} — ${site.tagline}`;
    }
    // Default SEO global — halaman boleh override via render({ metaDescription, ... })
    if (res.locals.seo === undefined) {
      res.locals.seo = {
        description: site.metaDescription || site.description,
        keywords: site.metaKeywords,
        robots: "index, follow",
        ogImage: site.ogImage,
      };
    }
    next();
  } catch (err) {
    next(err);
  }
}
