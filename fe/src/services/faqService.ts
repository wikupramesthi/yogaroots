import type { BackendPayload } from "../types/index.js";
import apiRequest from "./apiClient.js";

export async function getFaqs(): Promise<BackendPayload> {
	return apiRequest("/faqs");
}
