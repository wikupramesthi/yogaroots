import { env } from "../config/env.js";
import { yogaData } from "../data/yogaData.js";
import type { BackendPayload, SiteIdentity } from "../types/index.js";

/**
 * Identitas website dari backend (dikelola via /backend/website-identity).
 * - Timeout pendek (3,5 dtk): identitas tidak boleh menghambat render halaman.
 * - Cache in-memory 10 menit agar setiap request halaman tidak memukul backend.
 * - Selalu ada fallback (data statis) supaya halaman tetap render saat BE mati.
 */

// Bentuk default — kunci sama persis dengan yang dipakai views (site.*).
const FALLBACK: SiteIdentity = {
	name: yogaData.site.name,
	title: yogaData.site.name,
	tagline: yogaData.site.tagline,
	description: yogaData.site.description,
	phone: yogaData.site.phone,
	phoneTel: yogaData.site.phone,
	email: yogaData.site.email,
	address: yogaData.site.address,
	instagramHandle: yogaData.site.instagram,
	instagramHref: `https://www.instagram.com/${yogaData.site.instagram}/`,
	facebookHref: "",
	youtubeHref: "",
	tiktokHref: "",
	metaTitle: "",
	metaDescription: "",
	metaKeywords: "",
	gaId: "",
	siteVerification: "",
	logoUrl: "/img/logo.png",
	logoWhiteUrl: "/img/logo-white.png",
	faviconUrl: "/img/fav.png",
	ogImage: "/img/yogaroots_about1.jpg",
	year: new Date().getFullYear(),
};

const TTL_MS = 10 * 60 * 1000;
let cache: { data: SiteIdentity; expiresAt: number } = {
	data: FALLBACK,
	expiresAt: 0,
};
let inflight: Promise<SiteIdentity> | null = null;

function text(value: unknown, fallback = ""): string {
	const s = String(value ?? "").trim();
	return s || fallback;
}

/** Ambil handle @user dari URL instagram penuh untuk tampilan "@user". */
function instagramHandleFrom(url: string, fallback: string): string {
	const m = String(url || "").match(/instagram\.com\/([A-Za-z0-9._]+)/i);
	return m ? m[1] : fallback;
}

/** Normalisasi payload API -> bentuk siap pakai views (anti null/undefined). */
export function normalizeIdentity(
	api: Record<string, unknown> = {},
): SiteIdentity {
	const fallback = FALLBACK;
	const instagramHref = text(api.instagram_url);
	return {
		name: text(api.site_name, fallback.name),
		title: text(api.site_title, fallback.title),
		tagline: text(api.tagline, fallback.tagline),
		description: text(api.short_description, fallback.description),
		phone: text(api.phone, fallback.phone),
		phoneTel:
			text(api.phone, fallback.phoneTel).replace(/[^\d+]/g, "") ||
			fallback.phoneTel,
		email: text(api.email, fallback.email),
		address: text(api.address, fallback.address),
		instagramHandle: instagramHref
			? instagramHandleFrom(instagramHref, fallback.instagramHandle)
			: fallback.instagramHandle,
		instagramHref: instagramHref || fallback.instagramHref,
		facebookHref: text(api.facebook_url),
		youtubeHref: text(api.youtube_url),
		tiktokHref: text(api.tiktok_url),
		metaTitle: text(api.meta_title),
		metaDescription: text(api.meta_description),
		metaKeywords: text(api.meta_keywords),
		gaId: text(api.google_analytics_id),
		siteVerification: text(api.google_site_verification),
		logoUrl: text(api.logo_url, fallback.logoUrl),
		logoWhiteUrl: fallback.logoWhiteUrl,
		faviconUrl: text(api.favicon_url, fallback.faviconUrl),
		ogImage: text(api.og_image_url, fallback.ogImage),
		year: fallback.year,
	};
}

/** Bentuk default saat backend tidak terjangkau (halaman tetap render & SEO aman). */
export function defaultSite(): SiteIdentity {
	return { ...FALLBACK };
}

/**
 * Ambil identitas (pakai cache). Melempar error bila backend gagal —
 * gunakan resolveSite() bila ingin fallback otomatis.
 */
export async function getSiteIdentity(): Promise<SiteIdentity> {
	if (cache.expiresAt > Date.now()) return cache.data;
	if (!inflight) {
		inflight = fetchIdentity()
			.then((payload: BackendPayload) => {
				const normalized = normalizeIdentity(payload ?? {});
				cache = { data: normalized, expiresAt: Date.now() + TTL_MS };
				return normalized;
			})
			.finally(() => {
				inflight = null;
			});
	}
	return inflight;
}

/**
 * Fetch ringan khusus identitas: timeout 3,5 dtk (jangan ikut antrean
 * apiClient 10 dtk) agar halaman tetap cepat saat backend lambat/mati.
 */
async function fetchIdentity(): Promise<unknown> {
	const controller = new AbortController();
	const timer = setTimeout(() => controller.abort(), 3_500);
	try {
		const res = await fetch(`${env.API_URL}/website-identity`, {
			signal: controller.signal,
			headers: { Accept: "application/json", "X-Api-Key": env.API_KEY },
		});
		if (!res.ok) throw new Error(`Identity API: ${res.status}`);
		const json = await res.json();
		return json.data ?? json;
	} finally {
		clearTimeout(timer);
	}
}

/** Resolve aman untuk middleware: gagal -> fallback, halaman/SEO tetap jalan. */
export async function resolveSite(): Promise<SiteIdentity> {
	try {
		return await getSiteIdentity();
	} catch {
		return defaultSite();
	}
}
