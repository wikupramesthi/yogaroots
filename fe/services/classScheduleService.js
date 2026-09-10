import apiRequest from "./apiClient.js";

export async function getClassSchedules(params = {}) {
    const query = new URLSearchParams();

    if (params.date) {
        query.append("date", params.date);
    }

    if (params.level) {
        query.append("level", params.level);
    }

    if (params.time) {
        query.append("time", params.time);
    }

    if (params.studio_uuid) {
        query.append("studio_uuid", params.studio_uuid);
    }

    if (params.page) {
        query.append("page", params.page);
    }

    if (params.per_page) {
        query.append("per_page", params.per_page);
    }

    const queryString = query.toString();

    const endpoint = queryString
        ? `/class-schedules?${queryString}`
        : "/class-schedules";

    return await apiRequest(endpoint);
}

export async function getClassSchedule(uuid) {
    return await apiRequest(
        `/class-schedules/${uuid}`
    );
}