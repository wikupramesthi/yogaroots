import apiRequest from "./apiClient.js";

export async function getPackages(params = {}) {
  const query = new URLSearchParams();

  if (params.search) {
    query.append("search", params.search);
  }

  if (params.filter) {
    query.append("filter", params.filter);
  }

  if (params.sort) {
    query.append("sort", params.sort);
  }

  if (params.page) {
    query.append("page", params.page);
  }

  if (params.per_page) {
    query.append("per_page", params.per_page);
  }

  const queryString = query.toString();

  const endpoint = queryString ? `/packages?${queryString}` : "/packages";

  return await apiRequest(endpoint);
}

export async function getPackage(slug) {
  return await apiRequest(`/packages/${slug}`);
}
