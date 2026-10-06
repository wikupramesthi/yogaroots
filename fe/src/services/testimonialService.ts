import apiRequest from "./apiClient.js";
import type { BackendPayload } from "../types/index.js";

export async function getTestimonials(): Promise<BackendPayload> {
  return await apiRequest("/testimonials");
}
