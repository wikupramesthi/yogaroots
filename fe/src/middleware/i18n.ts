import { env } from "../config/env.js";
import { translations } from "../data/translations.js";
import type {
	Locale,
	NextFunction,
	Request,
	Response,
} from "../types/index.js";

const SUPPORTED: readonly Locale[] = ["en", "id", "ja", "ko", "zh"];

function isLocale(value: unknown): value is Locale {
	return (
		typeof value === "string" &&
		(SUPPORTED as readonly string[]).includes(value)
	);
}
const ONE_YEAR = 365 * 24 * 60 * 60;

function parseCookies(req: Request): Record<string, string> {
	const cookies: Record<string, string> = {};
	const header = req.headers.cookie;
	if (header) {
		header.split(";").forEach((c: string) => {
			const [k, ...v] = c.trim().split("=");
			try {
				cookies[k] = decodeURIComponent(v.join("=") || "");
			} catch {
				cookies[k] = "";
			}
		});
	}
	return cookies;
}

/** Ganti bahasa via ?lang=en|id|ja|ko|zh lalu redirect bersih. Cookie HttpOnly + Secure (prod). */
export function i18n(req: Request, res: Response, next: NextFunction) {
	const langParam = typeof req.query.lang === "string" ? req.query.lang : "";
	if (isLocale(langParam)) {
		const flags = [
			`locale=${langParam}`,
			"Path=/",
			`Max-Age=${ONE_YEAR}`,
			"SameSite=Lax",
			"HttpOnly",
			...(env.IS_PROD ? ["Secure"] : []),
		];
		res.setHeader("Set-Cookie", flags.join("; "));
		const url = new URL(
			req.originalUrl,
			`${req.protocol}://${req.get("host")}`,
		);
		url.searchParams.delete("lang");
		const safePath = `/${url.pathname.replace(/^[/\\]+/, "")}`;
		return res.redirect(safePath + url.search);
	}

	const cookies = parseCookies(req);
	const lang: Locale = isLocale(cookies.locale) ? cookies.locale : "en";
	res.locals.lang = lang;
	res.locals.t = translations[lang] || translations.en;
	next();
}
