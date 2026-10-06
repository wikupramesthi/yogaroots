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
const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

function bad(message: string): ApiError {
  const err = new Error(message) as ApiError;
  err.status = 400;
  return err;
}

export function cleanSlug(value: unknown, label = "slug"): string {
  const slug = String(value ?? "").trim().toLowerCase().slice(0, 120);
  if (!SLUG_RE.test(slug)) throw bad(`${label} is invalid`);
  return slug;
}

export function cleanText(
  value: unknown,
  { max = 100, label = "input" }: CleanTextOptions = {},
): string {
  const text = String(value ?? "").trim().slice(0, max);
  if (/[<>]/.test(text)) throw bad(`${label} contains forbidden characters`);
  return text;
}

export function cleanEmail(value: unknown): string {
  const email = String(value ?? "").trim().toLowerCase().slice(0, 160);
  if (!EMAIL_RE.test(email)) throw bad("Invalid email address");
  return email;
}

export function cleanPage(value: unknown): number {
  const page = Number.parseInt(String(value ?? "1"), 10);
  return Number.isFinite(page) && page > 0 ? Math.min(page, 1000) : 1;
}

export function cleanDate(value: unknown): string {
  const date = String(value ?? "").trim().slice(0, 10);
  if (!date) return "";
  if (!/^\d{4}-\d{2}-\d{2}$/.test(date)) throw bad("Invalid date format (YYYY-MM-DD)");
  return date;
}

export function validateBooking(body: Record<string, unknown> = {}): BookingPayload {
  const name = cleanText(body.name, { max: 80, label: "Name" });
  const email = cleanEmail(body.email);
  const kelas = cleanText(body.kelas, { max: 80, label: "Class" });
  const date = body.date ? cleanDate(body.date) : "";
  if (!name || !email || !kelas) throw bad("Name, email, and class are required");
  return { name, email, kelas, date };
}

export function validateContact(body: Record<string, unknown> = {}): ContactPayload {
  const name = cleanText(body.name, { max: 80, label: "Name" });
  const email = cleanEmail(body.email);
  const subject = cleanText(body.subject ?? "", { max: 120, label: "Subject" });
  const message = cleanText(body.message ?? "", { max: 2000, label: "Message" });
  // captcha: mendukung `captcha` / `captcha_answer` / `captcha_token` dari backend
  const captcha = cleanText(
    body.captcha ?? body.captcha_answer ?? body.captcha_token ?? "",
    { max: 20, label: "Captcha" },
  );
  if (!name || !email || !message) throw bad("Name, email, and message are required");
  return { name, email, subject, message, captcha };
}

export function validateNewsletter(body: Record<string, unknown> = {}): { email: string } {
  return { email: cleanEmail(body.email) };
}
