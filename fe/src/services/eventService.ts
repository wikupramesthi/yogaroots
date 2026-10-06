import apiRequest, { buildQuery } from "./apiClient.js";
import type { BackendPayload } from "../types/index.js";

export async function getEvents(params: Record<string, unknown> = {}): Promise<BackendPayload> {
  const qs = buildQuery(params, ["search", "filter", "date_from", "date_to", "page", "per_page"]);
  return await apiRequest(`/events${qs}`);
}

export async function getEvent(slug: string): Promise<BackendPayload> {
  return await apiRequest(`/events/${slug}`);
}
