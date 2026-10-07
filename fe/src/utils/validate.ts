/**
 * Lightweight input validation — FE is a theme, backend remains authoritative.
 * All functions return a clean string or throw ApiError (status 400).
 */
import type {
	ApiError,
	BookingPayload,
	CleanTextOptions,
	ContactPayload,
} from "../types/index.js";

const SLUG_RE = /^[a-z0-9]+(?:-[a-z0-9]+)*$/;
const SLUG_LOOSE_RE = /^[A-Za-z0-9_-]+$/;
const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
const PHONE_RE = /^[0-9+\-\s()]{6,20}$/;
export const UUID_RE =
	/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i;

function bad(message: string): ApiError {
	const err = new Error(message) as ApiError;
	err.status = 400;
	return err;
}

export function cleanSlug(value: unknown, label = "slug"): string {
	const slug = String(value ?? "")
		.trim()
		.toLowerCase()
		.slice(0, 120);
	if (!SLUG_RE.test(slug)) throw bad(`${label} is invalid`);
	return slug;
}

/**
 * Versi longgar untuk compose URL (sitemap, canonical): tidak pernah melempar,
 * nilai tak valid menjadi string kosong supaya pemanggil tetap fail-open.
 * Berbeda dari cleanSlug() yang ketat dan melempar ApiError.
 */
export function cleanSlugLoose(value: unknown): string {
	const s = String(value ?? "").trim();
	return SLUG_LOOSE_RE.test(s) ? s : "";
}

export function cleanText(
	value: unknown,
	{ max = 100, label = "input" }: CleanTextOptions = {},
): string {
	const text = String(value ?? "")
		.trim()
		.slice(0, max);
	if (/[<>]/.test(text)) throw bad(`${label} contains forbidden characters`);
	return text;
}

export function cleanEmail(value: unknown): string {
	const email = String(value ?? "")
		.trim()
		.toLowerCase()
		.slice(0, 160);
	if (!EMAIL_RE.test(email)) throw bad("Invalid email address");
	return email;
}

export function cleanPage(value: unknown): number {
	const page = Number.parseInt(String(value ?? "1"), 10);
	return Number.isFinite(page) && page > 0 ? Math.min(page, 1000) : 1;
}

export function cleanDate(value: unknown): string {
	const date = String(value ?? "")
		.trim()
		.slice(0, 10);
	if (!date) return "";
	if (!/^\d{4}-\d{2}-\d{2}$/.test(date))
		throw bad("Invalid date format (YYYY-MM-DD)");
	return date;
}

export function validateBooking(
	body: Record<string, unknown> = {},
): BookingPayload {
	const name = cleanText(body.name, { max: 80, label: "Name" });
	const email = cleanEmail(body.email);
	const kelas = cleanText(body.kelas, { max: 80, label: "Class" });
	const date = body.date ? cleanDate(body.date) : "";
	if (!name || !email || !kelas)
		throw bad("Name, email, and class are required");
	return { name, email, kelas, date };
}

export function validateContact(
	body: Record<string, unknown> = {},
): ContactPayload {
	const nama = cleanText(body.nama, { max: 80, label: "Name" });
	const email = cleanEmail(body.email);
	const no_telp = String(body.no_telp ?? "")
		.trim()
		.slice(0, 20);
	if (!PHONE_RE.test(no_telp)) throw bad("Invalid phone number");
	const isi = cleanText(body.isi, { max: 2000, label: "Message" });
	const captcha_id = String(body.captcha_id ?? "").trim();
	if (!UUID_RE.test(captcha_id))
		throw bad("Verification expired, please reload the page");
	const captcha_answer = Number.parseInt(String(body.captcha_answer ?? ""), 10);
	if (
		!Number.isInteger(captcha_answer) ||
		captcha_answer < 0 ||
		captcha_answer > 100
	) {
		throw bad("Invalid verification answer");
	}
	if (!nama || !isi) throw bad("Name, email, and message are required");
	return { nama, email, no_telp, isi, captcha_id, captcha_answer };
}

export function validateNewsletter(body: Record<string, unknown> = {}): {
	email: string;
} {
	return { email: cleanEmail(body.email) };
}
