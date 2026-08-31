import apiRequest from "./apiClient.js";

export async function getEvents() {
  return apiRequest("/events");
}

export async function getEventBySlug(slug) {
  return apiRequest(`/events/${slug}`);
}
