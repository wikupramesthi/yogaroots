import type { BackendPayload } from "../types/index.js";
import apiRequest from "./apiClient.js";

export async function getPage(slug: string): Promise<BackendPayload> {
	return await apiRequest(`/pages/${encodeURIComponent(slug)}`);
}
