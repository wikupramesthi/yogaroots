export const $ = (id: string): HTMLElement | null =>
	document.getElementById(id);

export function escapeHtml(s: unknown): string {
	return String(s ?? "")
		.replace(/&/g, "&amp;")
		.replace(/</g, "&lt;")
		.replace(/>/g, "&gt;")
		.replace(/"/g, "&quot;")
		.replace(/'/g, "&#x27;");
}

export function lockScroll() {
	document.body.style.overflow = "hidden";
}

export function unlockScroll() {
	const anyOpen = ["bookingModal", "eventModal"].some(
		(id) => $(id) && !$(id)!.classList.contains("hidden"),
	);
	if (!anyOpen) document.body.style.overflow = "";
}

export function onAction(
	handlers: Record<string, (el: HTMLElement, e: Event) => void>,
) {
	document.addEventListener("click", (e) => {
		const target = e.target;
		if (!(target instanceof Element)) return;
		const el = target.closest<HTMLElement>("[data-action]");
		const handler = el && handlers[el.dataset.action || ""];
		if (!el || !handler) return;
		e.preventDefault();
		handler(el, e);
	});
}
