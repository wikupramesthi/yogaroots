import apiRequest from "./apiClient.js";
import type { BackendPayload, SiteStats } from "../types/index.js";

/**
 * Statistik publik dari backend (agregat, tanpa PII).
 * Gagal -> null, halaman pakai angka fallback statis.
 */
export async function getSiteStats(): Promise<SiteStats | null> {
  try {
    const data: BackendPayload = await apiRequest("/site-stats");
    if (!data) return null;
    const num = (v: unknown): number | null =>
      Number.isInteger(v) && (v as number) >= 0 ? (v as number) : null;
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
export function formatStatCount(value: unknown, lang = "en"): string {
  if (!Number.isInteger(value) || (value as number) < 0) return "";
  const v = value as number;
  if (v < 1000) return String(v);
  const k = v / 1000;
  const str = (Math.round(k * 10) / 10).toString().replace(".", lang === "id" ? "," : ".");
  return `${str}K+`;
}
