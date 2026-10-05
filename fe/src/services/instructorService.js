import apiRequest, { buildQuery } from "./apiClient.js";

export async function getInstructors(params = {}) {
  const qs = buildQuery(params, ["page", "per_page"]);
  return await apiRequest(`/instructors${qs}`);
}
