import { Router } from "express";
import { env } from "../config/env.js";
import apiRequest from "../services/apiClient.js";
import type { Request, Response } from "../types/index.js";
import { cleanSlugLoose } from "../utils/validate.js";

/**
 * Sitemap XML dinamis + robots.txt.
 * - URL statis (10 halaman) + slug dinamis dari backend
 *   (classes, packages, articles->/blog, pages->/pages/:slug).
 * - Cache in-memory 1 jam agar tidak memukul backend tiap crawl.
 * - Fail-open: backend mati -> sajikan cache basi, atau minimal URL statis
 *   (tidak pernah 500 agar Google tidak menghapus sitemap).
 */

const router = Router();

const STATIC_URLS = [
	{ path: "/", changefreq: "daily", priority: "1.0" },
	{ path: "/about", changefreq: "monthly", priority: "0.8" },
	{ path: "/art-of-living", changefreq: "monthly", priority: "0.8" },
	{ path: "/classes", changefreq: "weekly", priority: "0.9" },
	{ path: "/schedules", changefreq: "daily", priority: "0.9" },
	{ path: "/instructors", changefreq: "weekly", priority: "0.7" },
	{ path: "/blog", changefreq: "weekly", priority: "0.8" },
	{ path: "/packages", changefreq: "weekly", priority: "0.8" },
	{ path: "/event", changefreq: "weekly", priority: "0.7" },
	{ path: "/gallery", changefreq: "monthly", priority: "0.5" },
	{ path: "/contact", changefreq: "yearly", priority: "0.5" },
];

// FE base path + endpoint backend (per_page mentok 50 sesuai validasi BE).
const DYNAMIC_SOURCES = [
	{
		base: "/classes",
		endpoint: "/classes?per_page=50",
		changefreq: "weekly",
		priority: "0.7",
	},
	{
		base: "/packages",
		endpoint: "/packages?per_page=50",
		changefreq: "weekly",
		priority: "0.7",
	},
	{
		base: "/blog",
		endpoint: "/articles",
		changefreq: "weekly",
		priority: "0.6",
	},
	{
		base: "/pages",
		endpoint: "/pages",
		changefreq: "monthly",
		priority: "0.5",
	},
];

const TTL_MS = 60 * 60 * 1000; // 1 jam
let cache: { xml: string; expiresAt: number } = { xml: "", expiresAt: 0 };

/** Escape untuk isi XML (loc). */
function escapeXml(value: unknown): string {
	return String(value ?? "")
		.replace(/&/g, "&amp;")
		.replace(/</g, "&lt;")
		.replace(/>/g, "&gt;")
		.replace(/"/g, "&quot;")
		.replace(/'/g, "&apos;");
}

/** Slug aman untuk URL: buang selain huruf/angka/strip/underscore. */
const cleanSlug = cleanSlugLoose;

function urlEntry(
	loc: string,
	changefreq: string,
	priority: string,
	lastmod: string,
): string {
	return (
		"  <url>\n" +
		`    <loc>${escapeXml(loc)}</loc>\n` +
		`    <lastmod>${lastmod}</lastmod>\n` +
		`    <changefreq>${changefreq}</changefreq>\n` +
		`    <priority>${priority}</priority>\n` +
		"  </url>\n"
	);
}

async function buildSitemap() {
	const today = new Date().toISOString().slice(0, 10); // YYYY-MM-DD
	const base = env.SITE_URL.replace(/\/+$/, "");
	const seen = new Set<string>();
	let xml =
		'<?xml version="1.0" encoding="UTF-8"?>\n' +
		'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n';

	const push = (path: string, changefreq: string, priority: string) => {
		if (!path || seen.has(path)) return;
		seen.add(path);
		xml += urlEntry(`${base}${path}`, changefreq, priority, today);
	};

	for (const s of STATIC_URLS) push(s.path, s.changefreq, s.priority);

	// Slug dinamis — tiap sumber gagal independen (satu mati tidak menggugurkan lain).
	const results = await Promise.allSettled(
		DYNAMIC_SOURCES.map((src) => apiRequest(src.endpoint)),
	);
	results.forEach((result, i) => {
		if (result.status !== "fulfilled") return;
		const data = result.value;
		const items = Array.isArray(data) ? data : data?.data || [];
		const src = DYNAMIC_SOURCES[i];
		for (const item of items) {
			const slug = cleanSlug(item?.slug);
			if (slug) push(`${src.base}/${slug}`, src.changefreq, src.priority);
		}
	});

	xml += "</urlset>";
	return xml;
}

router.get("/sitemap.xml", async (_req: Request, res: Response) => {
	try {
		if (!cache.xml || Date.now() > cache.expiresAt) {
			cache = { xml: await buildSitemap(), expiresAt: Date.now() + TTL_MS };
		}
		res.type("application/xml").send(cache.xml);
	} catch {
		// Terakhir: minimal URL statis, tanpa slug dinamis.
		try {
			const base = env.SITE_URL.replace(/\/+$/, "");
			const today = new Date().toISOString().slice(0, 10);
			let xml =
				'<?xml version="1.0" encoding="UTF-8"?>\n' +
				'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n';
			for (const s of STATIC_URLS) {
				xml += urlEntry(`${base}${s.path}`, s.changefreq, s.priority, today);
			}
			xml += "</urlset>";
			res.type("application/xml").send(xml);
		} catch {
			res.status(500).type("text/plain").send("Sitemap unavailable");
		}
	}
});

// robots.txt dinamis: Sitemap absolut mengikuti SITE_URL per environment.
router.get("/robots.txt", (_req: Request, res: Response) => {
	const base = env.SITE_URL.replace(/\/+$/, "");
	res
		.type("text/plain")
		.send(`User-agent: *\nAllow: /\n\nSitemap: ${base}/sitemap.xml\n`);
});

export default router;
