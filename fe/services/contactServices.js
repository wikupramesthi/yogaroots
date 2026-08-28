import apiRequest from "./apiClient.js";

export async function getContactCaptcha() {
  return await apiRequest("/contact/captcha");
}

export async function sendContact(data) {
  return await apiRequest("/contact", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  });
}
