import { env } from "../src/config/env.js";

const TIMEOUT_MS = 10_000;

/**
 * HTTP client terpusat ke backend Laravel.
 * - Base URL dari env (tidak ada hardcode)
 * - Timeout 10 detik agar request tidak menggantung
 * - Tidak membocorkan body backend mentah ke log
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
      const error = new Error(`Backend mengembalikan respons tak terduga (${response.status})`);
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
      const timeout = new Error("Backend timeout — coba lagi sebentar.");
      timeout.status = 504;
      throw timeout;
    }
    throw err;
  } finally {
    clearTimeout(timer);
  }
}

export default apiRequest;
