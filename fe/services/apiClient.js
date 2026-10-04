import { env } from "../src/config/env.js";

const TIMEOUT_MS = 10_000;

/**
 * Centralized HTTP client to Laravel backend.
 * - Base URL from env (no hardcoding)
 * - 10s timeout so requests don't hang
 * - Does not leak raw backend body to logs
 */
async function apiRequest(endpoint, options = {}) {
  const controller = new AbortController();
  const timer = setTimeout(() => controller.abort(), TIMEOUT_MS);

  try {
    const response = await fetch(`${env.API_URL}${endpoint}`, {
      ...options,
      signal: controller.signal,
      headers: { Accept: "application/json", ...options.headers },
    });

    const contentType = response.headers.get("content-type") || "";
    if (!contentType.includes("application/json")) {
      const error = new Error(`Backend returned an unexpected response (${response.status})`);
      error.status = response.status;
      throw error;
    }

    const result = await response.json();

    if (!response.ok) {
      const error = new Error(result.message || `API Error: ${response.status}`);
      error.status = response.status;
      error.errors = result.errors;
      throw error;
    }

    return result.data ?? result;
  } catch (err) {
    if (err.name === "AbortError") {
      const timeout = new Error("Backend timed out — please try again shortly.");
      timeout.status = 504;
      throw timeout;
    }
    throw err;
  } finally {
    clearTimeout(timer);
  }
}

export default apiRequest;
