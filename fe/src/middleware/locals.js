import { yogaData } from "../../data/yogaData.js";
import { siteContact, env } from "../config/env.js";

/**
 * Data global untuk semua views: site, nav, URL aman, kontak terpusat.
 * Mencegah host-header injection: canonical dibangun dari SITE_URL + path,
 * bukan dari header Host mentah.
 */
export function appLocals(req, res, next) {
  res.locals.site = yogaData.site;
  res.locals.nav = yogaData.nav;
  res.locals.contactLinks = siteContact;
  res.locals.currentPath = req.path;
  res.locals.currentUrl = `${env.SITE_URL}${req.path}`;
  // Versi asset untuk cache-busting (?v=) — naikkan tiap rilis statis
  res.locals.assetV = "20261002b";
  // `title` default — setiap halaman boleh override via render()
  if (res.locals.title === undefined) res.locals.title = "YogaRoots — Yoga, Meditation & Wellness";
  next();
}
