import apiRequest from "./apiClient.js";

export async function getInstructors(params = {}) {
  const query = new URLSearchParams();

  if (params.page) {
    query.append("page", params.page);
  }

  if (params.per_page) {
    query.append("per_page", params.per_page);
  }

  const queryString = query.toString();

  const endpoint = queryString ? `/instructors?${queryString}` : "/instructors";

  return await apiRequest(endpoint);
}
