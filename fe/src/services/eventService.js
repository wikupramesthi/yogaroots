import apiRequest, { buildQuery } from "./apiClient.js";

export async function getEvents(params = {}) {
    const qs = buildQuery(params, ["search", "filter", "date_from", "date_to", "page", "per_page"]);
    return await apiRequest(`/events${qs}`);
}


export async function getEvent(slug) {
    return await apiRequest(`/events/${slug}`);
}