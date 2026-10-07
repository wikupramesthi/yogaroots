import "dotenv/config";

/**
 * Centralised & validated environment config.
 * All URLs/numbers are defined here only — no hardcoding in views/services.
 */
function required(name: string, fallback?: string): string {
	const value = (process.env[name] ?? fallback ?? "").trim();
	if (!value)
		throw new Error(`Missing required env: ${name} (see .env.example)`);
	return value;
}

function optional(name: string, fallback = ""): string {
	return (process.env[name] ?? fallback).trim();
}

const rawApiUrl = required("API_URL", "http://127.0.0.1:8000/api");
const rawSiteUrl = optional("SITE_URL", "http://localhost:3000");

// API_URL berakhiran /api; endpoint web backend (auth) berada di root-nya.
const apiBase = rawApiUrl.replace(/\/+$/, "").replace(/\/api$/, "");

export const env = {
	NODE_ENV: optional("NODE_ENV", "development"),
	IS_PROD: optional("NODE_ENV", "development") === "production",
	PORT: Number(optional("PORT", "3000")) || 3000,

	// No trailing slash for consistent endpoint concat
	API_URL: rawApiUrl.replace(/\/+$/, ""),
	// Root backend Laravel — untuk endpoint web non-/api (mis. /auth/me)
	API_BASE: apiBase,
	// Nama cookie session Laravel. Hanya dipakai sebagai petunjuk cepat untuk
	// deciding apakah perlu memanggil backend; seluruh header Cookie tetap
	// diteruskan apa adanya supaya tidak perlu tahu nama ini di FE.
	SESSION_COOKIE: optional("SESSION_COOKIE_NAME", "laravel_session"),
	API_KEY: required("API_KEY"),
	SITE_URL: rawSiteUrl.replace(/\/+$/, ""),

	GOOGLE_AUTH_URL: optional(
		"GOOGLE_AUTH_URL",
		`${rawApiUrl.replace(/\/api$/, "")}/auth/google`,
	),
	WHATSAPP_NUMBER: optional("WHATSAPP_NUMBER", "6281321221270"),
	// Cache-busting untuk /css/* dan /js/* (?v=) — naikkan tiap rilis statis
	ASSET_V: optional("ASSET_V", "20261007a"),
	// "0" = matikan HTML minify (view-source readable saat debug)
	HTML_MINIFY: optional("HTML_MINIFY", "1"),
};

export const siteContact = {
	whatsappNumber: env.WHATSAPP_NUMBER,
	whatsappLink:
		`https://api.whatsapp.com/send/?phone=${encodeURIComponent(env.WHATSAPP_NUMBER)}` +
		`&text=${encodeURIComponent("Hi, I found you through your website and would like more information about your classes. Thank you!")}` +
		`&app_absent=0`,
	whatsappShortLink: `https://wa.me/${encodeURIComponent(env.WHATSAPP_NUMBER)}`,
	/**
	 * Login Google. `redirect` wajib diisi: tanpa itu backend melakukan
	 * redirect ke panel admin /backend/dashboard, bukan kembali ke situs publik.
	 */
	googleAuthUrl: `${env.GOOGLE_AUTH_URL}${env.GOOGLE_AUTH_URL.includes("?") ? "&" : "?"}redirect=${encodeURIComponent(env.SITE_URL)}`,
};
