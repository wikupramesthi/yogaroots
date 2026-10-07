import { env } from "../config/env.js";
import type {
	ApiError,
	ApiRequestOptions,
	BackendPayload,
} from "../types/index.js";

const TIMEOUT_MS = 10_000;

/**
 * Fetch mentah ke backend Laravel. Mengembalikan amplop apa adanya
 * (`{ data, meta, ... }`) supaya pemanggil bisa membaca `meta` untuk paginasi.
 * Melempar ApiError (status + errors) saat backend menolak.
 */
async function apiEnvelope(
	endpoint: string,
	options: ApiRequestOptions = {},
): Promise<BackendPayload> {
	const controller = new AbortController();
	const timer = setTimeout(() => controller.abort(), TIMEOUT_MS);

	try {
		const response = await fetch(`${env.API_URL}${endpoint}`, {
			...options,
			signal: controller.signal,
			headers: {
				...options.headers,
				Accept: "application/json",
				"X-Api-Key": env.API_KEY,
			},
		});

		const contentType = response.headers.get("content-type") || "";
		if (!contentType.includes("application/json")) {
			const error = new Error(
				`Backend returned an unexpected response (${response.status})`,
			) as ApiError;
			error.status = response.status;
			throw error;
		}

		const result = await response.json();

		if (!response.ok) {
			const error = new Error(
				result.message || `API Error: ${response.status}`,
			) as ApiError;
			error.status = response.status;
			error.errors = result.errors;
			throw error;
		}

		return result;
	} catch (err) {
		if ((err as { name?: string }).name === "AbortError") {
			const timeout = new Error(
				"Backend timed out — please try again shortly.",
			) as ApiError;
			timeout.status = 504;
			throw timeout;
		}
		throw err;
	} finally {
		clearTimeout(timer);
	}
}

/**
 * Centralized HTTP client to Laravel backend.
 * - Base URL from env (no hardcoding)
 * - 10s timeout so requests don't hang
 * - Does not leak raw backend body to logs
 * - Membuang amplop, hanya mengembalikan `data`
 */
async function apiRequest(
	endpoint: string,
	options: ApiRequestOptions = {},
): Promise<BackendPayload> {
	const result = await apiEnvelope(endpoint, options);
	return result?.data ?? result;
}

export interface PaginatedResult {
	items: BackendPayload;
	currentPage: number;
	lastPage: number;
	perPage: number;
	total: number;
}

/**
 * Untuk endpoint yang dipaginasikan Laravel (`meta` berisi current_page dll).
 * Falls back ke `currentPage = 1` bila backend tidak mengirim `meta`.
 */
export async function apiPaginated(
	endpoint: string,
	options: ApiRequestOptions = {},
): Promise<PaginatedResult> {
	const result = await apiEnvelope(endpoint, options);
	const meta = (result?.meta || {}) as Record<string, unknown>;
	const num = (v: unknown, fallback: number) => {
		const n = Number(v);
		return Number.isFinite(n) && n > 0 ? n : fallback;
	};
	const perPage = num(meta.per_page, 0);
	const total = num(meta.total, 0);

	return {
		items: result?.data ?? result,
		currentPage: num(meta.current_page, 1),
		lastPage: num(meta.last_page, 1),
		perPage,
		total: total || perPage,
	};
}

/**
 * Build a query string from whitelisted keys only.
 * Skips empty values to keep URLs clean.
 */
export function buildQuery(
	params: Record<string, unknown> = {},
	allowedKeys: string[] = [],
): string {
	const query = new URLSearchParams();
	for (const key of allowedKeys) {
		const value = params[key];
		if (value !== undefined && value !== null && value !== "") {
			query.append(key, String(value));
		}
	}
	const qs = query.toString();
	return qs ? `?${qs}` : "";
}

export default apiRequest;
