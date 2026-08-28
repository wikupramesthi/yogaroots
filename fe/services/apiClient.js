const API_URL = "http://127.0.0.1:8000/api";

async function apiRequest(endpoint, options = {}) {
  const response = await fetch(`${API_URL}${endpoint}`, {
    ...options,
    headers: {
      Accept: "application/json",
      ...options.headers,
    },
  });

  const contentType = response.headers.get("content-type") || "";

  let result;

  if (contentType.includes("application/json")) {
    result = await response.json();
  } else {
    const text = await response.text();

    console.error("NON JSON RESPONSE:", text);

    throw new Error(
      `Server Laravel mengembalikan response bukan JSON (${response.status})`,
    );
  }

  if (!response.ok) {
    const error = new Error(result.message || `API Error: ${response.status}`);

    error.status = response.status;
    error.errors = result.errors;

    throw error;
  }

  return result.data ?? result;
}

export default apiRequest;
