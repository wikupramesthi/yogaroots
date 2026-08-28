import apiRequest from "./apiClient.js";

export async function getFaqs() {
  return apiRequest("/faqs");
}
