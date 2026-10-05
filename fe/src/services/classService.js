import apiRequest, { buildQuery } from "./apiClient.js";

export async function getClasses(params = {}) {
    const qs = buildQuery(params, ["level", "instructor_uuid", "page", "per_page"]);
    return await apiRequest(`/classes${qs}`);
}

export async function getClass(slug) {
    return await apiRequest(`/classes/${slug}`);
}