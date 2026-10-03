/**
 * Validasi input ringan — FE adalah theme, backend tetap otoritatif.
 * Semua fungsi mengembalikan string bersih atau melempar { status: 400 }.
 */
const SLUG_RE = /^[a-z0-9]+(?:-[a-z0-9]+)*$/;
const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

function bad(message) {
  const err = new Error(message);
  err.status = 400;
  return err;
}

export function cleanSlug(value, label = "slug") {
  const slug = String(value ?? "").trim().toLowerCase().slice(0, 120);
  if (!SLUG_RE.test(slug)) throw bad(`${label} tidak valid`);
  return slug;
}

export function cleanText(value, { max = 100, label = "input" } = {}) {
  const text = String(value ?? "").trim().slice(0, max);
  if (/[<>]/.test(text)) throw bad(`${label} mengandung karakter terlarang`);
  return text;
}

export function cleanEmail(value) {
  const email = String(value ?? "").trim().toLowerCase().slice(0, 160);
  if (!EMAIL_RE.test(email)) throw bad("Email tidak valid");
  return email;
}

export function cleanPage(value) {
  const page = Number.parseInt(String(value ?? "1"), 10);
  return Number.isFinite(page) && page > 0 ? Math.min(page, 1000) : 1;
}

export function cleanDate(value) {
  const date = String(value ?? "").trim().slice(0, 10);
  if (!date) return "";
  if (!/^\d{4}-\d{2}-\d{2}$/.test(date)) throw bad("Format tanggal tidak valid (YYYY-MM-DD)");
  return date;
}

export function validateBooking(body = {}) {
  const name = cleanText(body.name, { max: 80, label: "Nama" });
  const email = cleanEmail(body.email);
  const kelas = cleanText(body.kelas, { max: 80, label: "Kelas" });
  const date = body.date ? cleanDate(body.date) : "";
  if (!name || !email || !kelas) throw bad("Nama, email, dan kelas wajib diisi");
  return { name, email, kelas, date };
}

export function validateContact(body = {}) {
  const name = cleanText(body.name, { max: 80, label: "Nama" });
  const email = cleanEmail(body.email);
  const subject = cleanText(body.subject ?? "", { max: 120, label: "Subjek" });
  const message = cleanText(body.message ?? "", { max: 2000, label: "Pesan" });
  // captcha: dukung `captcha` / `captcha_answer` / `captcha_token` dari backend
  const captcha = cleanText(
    body.captcha ?? body.captcha_answer ?? body.captcha_token ?? "",
    { max: 20, label: "Captcha" },
  );
  if (!name || !email || !message) throw bad("Nama, email, dan pesan wajib diisi");
  return { name, email, subject, message, captcha };
}

export function validateNewsletter(body = {}) {
  return { email: cleanEmail(body.email) };
}
