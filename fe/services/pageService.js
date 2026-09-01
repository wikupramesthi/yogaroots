import apiRequest from "./apiClient.js";

export async function getPage(slug) {
  return await apiRequest(`/pages/${slug}`);
}