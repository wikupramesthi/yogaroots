import apiRequest from "./apiClient.js";

export async function getEvents(params = {}) {
    const query = new URLSearchParams();

    if (params.search) {
        query.append("search", params.search);
    }

    if (params.filter) {
        query.append("filter", params.filter);
    }

    if (params.date_from) {
        query.append("date_from", params.date_from);
    }

    if (params.date_to) {
        query.append("date_to", params.date_to);
    }

    const queryString = query.toString();

    const endpoint = queryString
        ? `/events?${queryString}`
        : "/events";

    return await apiRequest(endpoint);
}


export async function getEvent(slug) {
    return await apiRequest(`/events/${slug}`);
}