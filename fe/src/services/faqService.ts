import apiRequest from "./apiClient.js";
import type { BackendPayload } from "../types/index.js";

export async function getFaqs(): Promise<BackendPayload> {
  return apiRequest("/faqs");
}
