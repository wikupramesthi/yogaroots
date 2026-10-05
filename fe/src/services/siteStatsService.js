import apiRequest from "./apiClient.js";

/**
 * Statistik publik dari backend (agregat, tanpa PII).
 * Gagal -> null, halaman pakai angka fallback statis.
 */
export async function getSiteStats() {
  try {
    const data = await apiRequest("/site-stats");
    if (!data) return null;
    const num = (v) => (Number.isInteger(v) && v >= 0 ? v : null);
    const members = num(data.members);
    const instructors = num(data.instructors);
    const classes = num(data.classes);
    if (members === null && instructors === null && classes === null) return null;
    return { members, instructors, classes };
  } catch {
    return null;
  }
}

/** Format angka statistik: 950 -> "950", 12.400 -> "12,4K+" (id) / "12.4K+" (lainnya). */
export function formatStatCount(value, lang = "en") {
  if (!Number.isInteger(value) || value < 0) return "";
  if (value < 1000) return String(value);
  const k = value / 1000;
  const str = (Math.round(k * 10) / 10).toString().replace(".", lang === "id" ? "," : ".");
  return `${str}K+`;
}
