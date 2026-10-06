import apiRequest from "./apiClient.js";
import type { BackendPayload } from "../types/index.js";

export async function getPage(slug: string): Promise<BackendPayload> {
  return await apiRequest(`/pages/${slug}`);
}
