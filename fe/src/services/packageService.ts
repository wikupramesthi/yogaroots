import type { BackendPayload } from "../types/index.js";
import apiRequest, {
	apiPaginated,
	buildQuery,
	type PaginatedResult,
} from "./apiClient.js";

export async function getPackages(
	params: Record<string, unknown> = {},
): Promise<BackendPayload> {
	const qs = buildQuery(params, [
		"search",
		"filter",
		"sort",
		"page",
		"per_page",
	]);
	return await apiRequest(`/packages${qs}`);
}

/** Versi paginated: mengembalikan `meta` Laravel untuk UI pagination. */
export async function getPackagesPaginated(
	params: Record<string, unknown> = {},
): Promise<PaginatedResult> {
	const qs = buildQuery(params, [
		"search",
		"filter",
		"sort",
		"page",
		"per_page",
	]);
	return await apiPaginated(`/packages${qs}`);
}

export async function getPackage(slug: string): Promise<BackendPayload> {
	return await apiRequest(`/packages/${encodeURIComponent(slug)}`);
}
