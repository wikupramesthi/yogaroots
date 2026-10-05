import apiRequest, { buildQuery } from "./apiClient.js";

export async function getClassSchedules(params = {}) {
    const qs = buildQuery(params, ["date", "level", "time", "studio_uuid", "page", "per_page"]);
    return await apiRequest(`/class-schedules${qs}`);
}

export async function getClassSchedule(uuid) {
    return await apiRequest(
        `/class-schedules/${uuid}`
    );
}