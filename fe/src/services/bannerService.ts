import type { BackendPayload } from "../types/index.js";
import apiRequest from "./apiClient.js";

export async function getBanners(
	posisi: string | null = null,
): Promise<BackendPayload> {
	const url = posisi
		? `/banners?kategori=${encodeURIComponent(posisi)}`
		: "/banners";

	const response = await apiRequest(url);

	return response;
}
