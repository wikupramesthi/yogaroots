import apiRequest from "./apiClient.js";

export async function getTestimonials() {
  return await apiRequest("/testimonials");
}