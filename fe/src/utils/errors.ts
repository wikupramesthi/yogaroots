import type { ApiError } from "../types/index.js";

export function toApiError(err: unknown): ApiError {
	if (err instanceof Error) return err as ApiError;
	return new Error(typeof err === "string" ? err : "Unknown error") as ApiError;
}
