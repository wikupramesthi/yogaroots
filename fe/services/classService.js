import apiRequest from "./apiClient.js";

export async function getClasses(params = {}) {
    const query = new URLSearchParams();

    if (params.level) {
        query.append("level", params.level);
    }

    if (params.instructor_uuid) {
        query.append("instructor_uuid", params.instructor_uuid);
    }

    if (params.page) {
        query.append("page", params.page);
    }

    if (params.per_page) {
        query.append("per_page", params.per_page);
    }

    const queryString = query.toString();

    const endpoint = queryString
        ? `/classes?${queryString}`
        : "/classes";

    return await apiRequest(endpoint);
}

export async function getClass(slug) {
    return await apiRequest(`/classes/${slug}`);
}