import type { BackendPayload, ContactPayload } from "../types/index.js";
import apiRequest from "./apiClient.js";

export async function getContactCaptcha(): Promise<BackendPayload> {
	return await apiRequest("/contact/captcha");
}

export async function sendContact(
	data: ContactPayload,
): Promise<BackendPayload> {
	return await apiRequest("/contact", {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify(data),
	});
}
