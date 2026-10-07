import type { BackendPayload } from "../types/index.js";
import apiRequest, { buildQuery } from "./apiClient.js";

export async function getClasses(
	params: Record<string, unknown> = {},
): Promise<BackendPayload> {
	const qs = buildQuery(params, [
		"level",
		"instructor_uuid",
		"page",
		"per_page",
	]);
	return await apiRequest(`/classes${qs}`);
}

export async function getClass(slug: string): Promise<BackendPayload> {
	return await apiRequest(`/classes/${encodeURIComponent(slug)}`);
}
