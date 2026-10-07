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

export const env = {
	NODE_ENV: optional("NODE_ENV", "development"),
	IS_PROD: optional("NODE_ENV", "development") === "production",
	PORT: Number(optional("PORT", "3000")) || 3000,

	// No trailing slash for consistent endpoint concat
	API_URL: rawApiUrl.replace(/\/+$/, ""),
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
	googleAuthUrl: env.GOOGLE_AUTH_URL,
};
