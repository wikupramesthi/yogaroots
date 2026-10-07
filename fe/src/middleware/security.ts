import { randomBytes } from "node:crypto";
import rateLimit from "express-rate-limit";
import helmet from "helmet";
import { env } from "../config/env.js";
import type { NextFunction, Request, Response } from "../types/index.js";

const GA_SCRIPT = "https://www.googletagmanager.com";
const GA_CONNECT = [
	"https://www.google-analytics.com",
	"https://*.google-analytics.com",
	"https://*.analytics.google.com",
	"https://www.googletagmanager.com",
];

/** Nonce per request untuk <script> inline yang memang dibutuhkan (res.locals.nonce). */
export function cspNonce(_req: Request, res: Response, next: NextFunction) {
	res.locals.nonce = randomBytes(16).toString("base64");
	next();
}

/**
 * Security headers. Script hanya dari 'self' + nonce per request:
 * tanpa 'unsafe-inline', tanpa handler atribut (onclick=...).
 */
export function securityHeaders() {
	return helmet({
		contentSecurityPolicy: {
			useDefaults: false,
			directives: {
				defaultSrc: ["'self'"],
				baseUri: ["'self'"],
				frameAncestors: ["'none'"],
				objectSrc: ["'none'"],
				scriptSrc: [
					"'self'",
					(_req, res) => `'nonce-${(res as Response).locals.nonce}'`,
					GA_SCRIPT,
				],
				scriptSrcAttr: ["'none'"],
				styleSrc: ["'self'", "'unsafe-inline'", "https://fonts.googleapis.com"],
				fontSrc: ["'self'", "https://fonts.gstatic.com"],
				imgSrc: [
					"'self'",
					"data:",
					"https:",
					new URL(env.API_URL).origin,
					...(env.IS_PROD ? [] : ["http:"]),
				],
				frameSrc: [
					"'self'",
					"https://www.google.com",
					"https://maps.google.com",
					"https://www.youtube.com",
					"https://www.youtube-nocookie.com",
					"https://player.vimeo.com",
				],
				connectSrc: ["'self'", ...GA_CONNECT],
				formAction: ["'self'"],
				...(env.IS_PROD ? { upgradeInsecureRequests: [] } : {}),
			},
		},
		crossOriginEmbedderPolicy: false,
		referrerPolicy: { policy: "strict-origin-when-cross-origin" },
	});
}

/** Rate limit untuk /api/* (anti spam bot). */
export function writeLimiter() {
	return rateLimit({
		windowMs: 60 * 1000,
		max: 20,
		standardHeaders: "draft-7",
		legacyHeaders: false,
		message: {
			success: false,
			message: "Too many requests, please try again shortly.",
		},
	});
}

/** Tolak POST lintas origin (CSRF sederhana untuk fetch JSON). */
export function sameOriginOnly(
	req: Request,
	res: Response,
	next: NextFunction,
) {
	const origin = req.get("origin");
	if (origin && req.method !== "GET" && req.method !== "HEAD") {
		try {
			const expectedHost = req.get("host");
			const originHost = new URL(origin).host;
			if (originHost !== expectedHost) {
				return res
					.status(403)
					.json({ success: false, message: "Origin not allowed." });
			}
		} catch {
			return res
				.status(403)
				.json({ success: false, message: "Invalid origin." });
		}
	}
	next();
}
