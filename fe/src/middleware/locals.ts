import { createHash } from "node:crypto";
import { env, siteContact } from "../config/env.js";
import { yogaData } from "../data/yogaData.js";
import { getSessionUser, hasSessionCookie } from "../services/authService.js";
import { resolveSite } from "../services/siteIdentityService.js";
import type {
	NextFunction,
	Request,
	Response,
	SessionUser,
	SiteIdentity,
} from "../types/index.js";

/**
 * Cache session per-cookie. Tanpa ini setiap render halaman menembak
 * backend. TTL pendek supaya logout/profil baru terasa cepat, dan
 * request anonim (tanpa cookie session) tidak pernah memanggil backend.
 */
const SESSION_TTL_MS = 30_000;
type SessionCacheEntry = { user: SessionUser | null; expiresAt: number };
const sessionCache = new Map<string, SessionCacheEntry>();

// Jaga supaya cache tidak tumbuh tanpa batas pada polling scraper.
const SESSION_CACHE_MAX = 500;

/** Dipanggil setelah logout supaya render berikutnya langsung anonim. */
export function clearSessionCache(): void {
	sessionCache.clear();
}

async function resolveUser(cookieHeader?: string): Promise<SessionUser | null> {
	if (!hasSessionCookie(cookieHeader)) return null;

	const cookie = cookieHeader as string;
	const key = createHash("sha256").update(cookie).digest("base64url");
	const hit = sessionCache.get(key);
	if (hit && hit.expiresAt > Date.now()) return hit.user;

	const user = await getSessionUser(cookie);

	if (sessionCache.size >= SESSION_CACHE_MAX) sessionCache.clear();
	sessionCache.set(key, { user, expiresAt: Date.now() + SESSION_TTL_MS });

	return user;
}

/**
 * Data global untuk semua views: site (dinamis dari API identitas),
 * nav, URL aman, kontak terpusat, status login, dan default SEO.
 * Mencegah host-header injection: canonical dibangun dari SITE_URL + path,
 * bukan dari header Host mentah.
 */
export async function appLocals(
	req: Request,
	res: Response,
	next: NextFunction,
) {
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
		// Status login. Gagal membaca session tidak boleh menggagalkan render —
		// null = anonim, halaman tetap tampil normal.
		res.locals.user = await resolveUser(req.headers?.cookie);
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
