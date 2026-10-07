import type { BackendPayload } from "../types/index.js";
import { sanitizeRichHtml } from "../utils/sanitize.js";
import apiRequest, {
	apiPaginated,
	buildQuery,
	type PaginatedResult,
} from "./apiClient.js";

function sanitizeEvent<T>(event: T): T {
	if (!event || typeof event !== "object") return event;
	const e = event as Record<string, unknown>;
	return { ...e, deskripsi: sanitizeRichHtml(e.deskripsi) } as T;
}

function sanitizePayload(payload: BackendPayload): BackendPayload {
	if (Array.isArray(payload)) return payload.map(sanitizeEvent);
	if (payload && Array.isArray(payload.data)) {
		return { ...payload, data: payload.data.map(sanitizeEvent) };
	}
	return sanitizeEvent(payload);
}

export async function getEvents(
	params: Record<string, unknown> = {},
): Promise<BackendPayload> {
	const qs = buildQuery(params, [
		"search",
		"filter",
		"date_from",
		"date_to",
		"page",
		"per_page",
	]);
	return sanitizePayload(await apiRequest(`/events${qs}`));
}

/** Versi paginated: mengembalikan `meta` Laravel untuk UI pagination. */
export async function getEventsPaginated(
	params: Record<string, unknown> = {},
): Promise<PaginatedResult> {
	const qs = buildQuery(params, [
		"search",
		"filter",
		"date_from",
		"date_to",
		"page",
		"per_page",
	]);
	const page = await apiPaginated(`/events${qs}`);
	return { ...page, items: sanitizePayload(page.items) };
}

export async function getEvent(slug: string): Promise<BackendPayload> {
	return sanitizePayload(
		await apiRequest(`/events/${encodeURIComponent(slug)}`),
	);
}
