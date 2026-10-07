import { $ } from "../lib/dom";

async function postJSON(url: string, body: unknown) {
	const res = await fetch(url, {
		method: "POST",
		headers: { "Content-Type": "application/json", Accept: "application/json" },
		body: JSON.stringify(body),
	});
	const data = await res.json().catch(() => ({}));
	if (!res.ok)
		throw new Error(data.message || "Failed to send. Please try again.");
	return data;
}

(() => {
	const form = $("contactForm") as HTMLFormElement | null;
	if (!form) return;
	const button = form.querySelector("button") as HTMLButtonElement | null;
	const message = $("contactMsg");
	const idleLabel = button ? button.textContent : "";
	const captchaQuestion = $("captchaQuestion");
	const captchaId = $("captchaId") as HTMLInputElement | null;
	const captchaAnswer = $("captchaAnswer") as HTMLInputElement | null;

	const refreshCaptcha = async () => {
		try {
			const res = await fetch("/api/contact/captcha", {
				headers: { Accept: "application/json" },
			});
			const data = await res.json();
			if (!res.ok || !data.captcha_id) return;
			if (captchaId) captchaId.value = data.captcha_id;
			if (captchaQuestion) captchaQuestion.textContent = data.question;
			if (captchaAnswer) captchaAnswer.value = "";
		} catch {
			/* keep current captcha */
		}
	};

	form.addEventListener("submit", async (e) => {
		e.preventDefault();
		if (button) {
			button.disabled = true;
			button.textContent = form.dataset.sending || "Sending...";
		}
		try {
			const result = await postJSON(
				"/api/contact",
				Object.fromEntries(new FormData(form).entries()),
			);
			form.reset();
			if (message) {
				message.className = "text-sm p-3 rounded-xl bg-green-50 text-green-700";
				message.textContent = result.message;
			}
		} catch (err) {
			if (message) {
				message.className = "text-sm p-3 rounded-xl bg-red-50 text-red-700";
				message.textContent = (err as Error).message;
			}
		} finally {
			await refreshCaptcha();
			if (button) {
				button.disabled = false;
				button.textContent = idleLabel;
			}
		}
	});
})();

document.querySelectorAll("[data-faq]").forEach((btn) => {
	btn.addEventListener("click", () => {
		const content = btn.nextElementSibling;
		if (!content) return;
		const willOpen = content.classList.contains("hidden");
		document.querySelectorAll("[data-faq] + div").forEach((d) => {
			d.classList.add("hidden");
		});
		if (willOpen) content.classList.remove("hidden");
	});
});
