import apiRequest, { buildQuery } from "./apiClient.js";
import type { BackendPayload } from "../types/index.js";

export async function getPackages(params: Record<string, unknown> = {}): Promise<BackendPayload> {
  const qs = buildQuery(params, ["search", "filter", "sort", "page", "per_page"]);
  return await apiRequest(`/packages${qs}`);
}

export async function getPackage(slug: string): Promise<BackendPayload> {
  return await apiRequest(`/packages/${slug}`);
}
