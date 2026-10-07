import { $, escapeHtml, lockScroll, onAction, unlockScroll } from "../lib/dom";

interface EventData {
	judul?: string;
	tanggal?: string;
	waktu_mulai?: string;
	waktu_selesai?: string;
	lokasi?: string;
	deskripsi?: string;
}

const eventModal = $("eventModal");
let eventsData: EventData[] = [];
try {
	const parsed = JSON.parse($("eventsData")?.textContent || "[]");
	if (Array.isArray(parsed)) eventsData = parsed;
} catch {
	eventsData = [];
}

const META_ICONS: Record<string, string> = {
	date: '<path d="M8 3v4m8-4v4M4 9h16M6 5h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2z"></path>',
	time: '<circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 2"></path>',
	place:
		'<path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a 1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle>',
};

function metaItem(icon: string, text: string): string {
	return (
		'<span class="flex items-center gap-1.5">' +
		'<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' +
		icon +
		"</svg>" +
		escapeHtml(text) +
		"</span>"
	);
}

function openEvent(i: number) {
	const e = eventsData[i];
	const title = $("eventTitle");
	const meta = $("eventMeta");
	const desc = $("eventDesc");
	if (!e || !eventModal || !title || !meta || !desc) return;
	title.textContent = e.judul || "";

	let html = "";
	if (e.tanggal) html += metaItem(META_ICONS.date, e.tanggal);
	if (e.waktu_mulai) {
		const range =
			String(e.waktu_mulai).substring(0, 5) +
			(e.waktu_selesai ? ` - ${String(e.waktu_selesai).substring(0, 5)}` : "");
		html += metaItem(META_ICONS.time, range);
	}
	if (e.lokasi) html += metaItem(META_ICONS.place, e.lokasi);
	meta.innerHTML = html;

	// Deskripsi dari CMS backend (disanitasi server-side di eventService).
	desc.innerHTML = e.deskripsi || "";

	const wa = $("eventWhatsApp") as HTMLAnchorElement | null;
	// No hardcoded WA number — base wajib dari server via data-wa-base (contactLinks).
	if (e.judul && wa?.dataset.waBase) {
		wa.href =
			wa.dataset.waBase +
			"?text=" +
			encodeURIComponent(`Hi, I want to book a spot for: ${e.judul}`);
	}
	eventModal.classList.remove("hidden");
	lockScroll();
}

function closeEvent() {
	eventModal?.classList.add("hidden");
	unlockScroll();
}

onAction({
	"open-event": (el) => openEvent(parseInt(el.dataset.eventIndex || "", 10)),
	"close-event": closeEvent,
});

document.addEventListener("keydown", (ev) => {
	if (ev.key === "Escape") closeEvent();
});
