import apiRequest from "./apiClient.js";

export async function getBanners(posisi = null) {
  const url = posisi
    ? `/banners?kategori=${encodeURIComponent(posisi)}`
    : "/banners";

  const response = await apiRequest(url);

  console.log("BANNER API:", response);

  return response;
}
