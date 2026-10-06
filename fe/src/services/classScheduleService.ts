import apiRequest, { buildQuery } from "./apiClient.js";
import type { BackendPayload } from "../types/index.js";

export async function getClassSchedules(params: Record<string, unknown> = {}): Promise<BackendPayload> {
  const qs = buildQuery(params, ["date", "level", "time", "studio_uuid", "page", "per_page"]);
  return await apiRequest(`/class-schedules${qs}`);
}

export async function getClassSchedule(uuid: string): Promise<BackendPayload> {
  return await apiRequest(`/class-schedules/${uuid}`);
}
