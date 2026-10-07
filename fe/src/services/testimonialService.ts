import type { BackendPayload } from "../types/index.js";
import apiRequest from "./apiClient.js";

export async function getTestimonials(): Promise<BackendPayload> {
	return await apiRequest("/testimonials");
}
