import apiRequest from "./apiClient.js";

export async function getTestimonials() {
  return apiRequest("/testimonials");
}
