import apiRequest, { buildQuery } from "./apiClient.js";

export async function getPackages(params = {}) {
  const qs = buildQuery(params, ["search", "filter", "sort", "page", "per_page"]);
  return await apiRequest(`/packages${qs}`);
}

export async function getPackage(slug) {
  return await apiRequest(`/packages/${slug}`);
}
