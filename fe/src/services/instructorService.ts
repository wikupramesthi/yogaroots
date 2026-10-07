import type { BackendPayload } from "../types/index.js";
import apiRequest, { buildQuery } from "./apiClient.js";

export async function getInstructors(
	params: Record<string, unknown> = {},
): Promise<BackendPayload> {
	const qs = buildQuery(params, ["page", "per_page"]);
	return await apiRequest(`/instructors${qs}`);
}
