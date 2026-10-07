import { $, escapeHtml } from "../lib/dom";

interface ScheduleItem {
	start_time?: string;
	end_time?: string;
	duration?: number | string;
	capacity?: number | null;
	class?: { name?: string; description?: string; level?: string };
	instructor?: { name?: string };
	studio?: { uuid?: string; name?: string };
}

interface Studio {
	uuid: string;
	name?: string;
}

interface State {
	selected: Date;
	weekStart: Date;
	level: string;
	time: string;
	studio: string;
}

const startOfDay = (d: Date) =>
	new Date(d.getFullYear(), d.getMonth(), d.getDate());
const startOfWeek = (d: Date) =>
	new Date(d.getFullYear(), d.getMonth(), d.getDate() - d.getDay());
const sameDay = (a: Date, b: Date) => a.getTime() === b.getTime();

function fmtISO(d: Date): string {
	const y = d.getFullYear();
	const m = String(d.getMonth() + 1).padStart(2, "0");
	const da = String(d.getDate()).padStart(2, "0");
	return `${y}-${m}-${da}`;
}

const state: State = {
	selected: startOfDay(new Date()),
	weekStart: startOfWeek(new Date()),
	level: "",
	time: "",
	studio: "",
};

const dateRow = $("dateRow");
const scheduleList = $("scheduleList");
const scheduleTitle = $("scheduleTitle");
const scheduleCount = $("scheduleCount");
const scheduleFilterNote = $("scheduleFilterNote");
const studioFilters = $("studioFilters");

const CARD =
	'<div class="bg-white rounded-[20px] sm:rounded-[24px] border border-sage-100 p-6 sm:p-10 text-center';

const optionLabel =
	'<label class="flex items-center gap-3 cursor-pointer py-1.5 sm:py-1 min-h-[40px] sm:min-h-0">';
const optionBox = ' class="w-5 h-5 sm:w-4 sm:h-4 accent-sage-700 shrink-0" />';

/* ---------- date selector ---------- */

function renderDates() {
	if (!dateRow) return;
	let html = "";
	for (let i = 0; i < 7; i++) {
		const d = new Date(state.weekStart);
		d.setDate(d.getDate() + i);
		const isSelected = sameDay(d, state.selected);
		const isToday = sameDay(d, startOfDay(new Date()));
		html +=
			'<button type="button" data-date="' +
			fmtISO(d) +
			'" class="date-item flex-1 min-w-[60px] sm:min-w-[76px] snap-start px-2 sm:px-3 py-2 sm:py-3 rounded-xl sm:rounded-2xl text-center transition active:scale-[0.98] ' +
			(isSelected
				? "bg-sage-700 text-white shadow-sm"
				: "hover:bg-sage-50 active:bg-sage-100 " +
					(isToday ? "border border-sage-300" : "border border-transparent")) +
			'">' +
			'<div class="text-[11px] sm:text-xs ' +
			(isSelected ? "opacity-80" : "text-stone-warm") +
			'">' +
			d.toLocaleDateString("en-US", { weekday: "short" }) +
			"</div>" +
			'<div class="text-lg sm:text-xl font-bold mt-0.5 sm:mt-1 leading-tight">' +
			d.getDate() +
			"</div>" +
			'<div class="text-[10px] sm:text-[11px] ' +
			(isSelected ? "opacity-80" : "text-stone-warm") +
			' mt-0.5">' +
			d.toLocaleDateString("en-US", { month: "short" }) +
			"</div></button>";
	}
	dateRow.innerHTML = html;
}

dateRow?.addEventListener("click", (e) => {
	const btn = (e.target as Element).closest<HTMLElement>("[data-date]");
	if (!btn) return;
	state.selected = new Date(`${btn.getAttribute("data-date")}T00:00:00`);
	renderDates();
	loadAll();
});

$("todayBtn")?.addEventListener("click", () => {
	state.selected = startOfDay(new Date());
	state.weekStart = startOfWeek(new Date());
	renderDates();
	loadAll();
});

$("weekPrev")?.addEventListener("click", () => {
	state.weekStart.setDate(state.weekStart.getDate() - 7);
	state.selected.setDate(state.selected.getDate() - 7);
	renderDates();
	loadAll();
});

$("weekNext")?.addEventListener("click", () => {
	state.weekStart.setDate(state.weekStart.getDate() + 7);
	state.selected.setDate(state.selected.getDate() + 7);
	renderDates();
	loadAll();
});

/* ---------- filters ---------- */

function filterGroup(name: string): HTMLElement | null {
	return document.querySelector<HTMLElement>(`[data-filter-group="${name}"]`);
}

function checkboxes(group: HTMLElement): HTMLInputElement[] {
	return Array.from(
		group.querySelectorAll<HTMLInputElement>('input[type="checkbox"]'),
	);
}

function groupValue(name: string): string {
	const group = filterGroup(name);
	if (!group) return "";
	const checked = checkboxes(group).filter((b) => b.checked && b.value !== "");
	return checked.length ? checked[0].value : "";
}

function bindGroup(name: string) {
	const group = filterGroup(name);
	group?.addEventListener("change", (e) => {
		const target = e.target as HTMLInputElement;
		const boxes = checkboxes(group);
		if (target.value === "") {
			boxes.forEach((b) => {
				b.checked = b === target;
			});
		} else {
			boxes.forEach((b) => {
				if (b.value === "") b.checked = false;
				if (b !== target) b.checked = false;
			});
			target.checked = true;
		}
		state.level = groupValue("level");
		state.time = groupValue("time");
		state.studio = groupValue("studio");
		loadSchedules();
	});
}

$("resetFilters")?.addEventListener("click", () => {
	document.querySelectorAll<HTMLElement>("[data-filter-group]").forEach((g) => {
		checkboxes(g).forEach((b) => {
			b.checked = b.value === "";
		});
	});
	state.level = "";
	state.time = "";
	state.studio = "";
	loadSchedules();
});

function renderStudioOptions(studios: Studio[]) {
	if (!studioFilters) return;
	if (state.studio && !studios.some((s) => s.uuid === state.studio))
		state.studio = "";
	const current = state.studio;
	let html =
		optionLabel +
		'<input type="checkbox" value="" ' +
		(current === "" ? "checked" : "") +
		optionBox +
		'<span class="text-sm">All Studios</span></label>';
	studios.forEach((s) => {
		html +=
			optionLabel +
			'<input type="checkbox" value="' +
			escapeHtml(s.uuid) +
			'" ' +
			(current === s.uuid ? "checked" : "") +
			optionBox +
			'<span class="text-sm">' +
			escapeHtml(s.name) +
			"</span></label>";
	});
	studioFilters.innerHTML = html;
	if (!studios.length) {
		studioFilters.innerHTML =
			'<p class="text-sm text-stone-warm">No studios scheduled for this date.</p>';
	}
}

/* ---------- fetch ---------- */

function timeLabel(start: string | undefined): string {
	const h = parseInt(String(start).split(":")[0], 10);
	if (h < 12) return "Morning";
	if (h < 17) return "Afternoon";
	return "Evening";
}

function capitalize(s: string | undefined): string {
	if (!s) return "";
	return s.charAt(0).toUpperCase() + s.slice(1);
}

async function fetchJSON(url: string): Promise<ScheduleItem[]> {
	const res = await fetch(url, { headers: { Accept: "application/json" } });
	const data = await res.json().catch(() => []);
	if (!res.ok) throw new Error("Failed to load data");
	return Array.isArray(data) ? data : [];
}

async function loadStudios() {
	try {
		const all = await fetchJSON(
			`/api/class-schedules?date=${fmtISO(state.selected)}`,
		);
		const seen: Record<string, boolean> = {};
		const studios: Studio[] = [];
		all.forEach((s) => {
			const st = s.studio;
			if (st?.uuid && !seen[st.uuid]) {
				seen[st.uuid] = true;
				studios.push({ uuid: st.uuid, name: st.name });
			}
		});
		renderStudioOptions(studios);
	} catch {
		renderStudioOptions([]);
	}
}

async function emptyState() {
	if (!scheduleList) return;
	const next = new Date(state.selected);
	let found: Date | null = null;
	for (let i = 1; i <= 14; i++) {
		next.setDate(next.getDate() + 1);
		try {
			const list = await fetchJSON(
				`/api/class-schedules?date=${fmtISO(next)}&per_page=1`,
			);
			if (list.length) {
				found = new Date(next);
				break;
			}
		} catch {
			break;
		}
	}
	const msg = "No classes found for this date and filter selection.";
	const btn = found
		? '<button type="button" id="nextAvailable" data-date="' +
			fmtISO(found) +
			'" class="block mx-auto mt-4 px-5 py-2.5 rounded-full bg-sage-700 text-white text-sm font-semibold hover:bg-sage-800 transition">See ' +
			found.toLocaleDateString("en-US", {
				weekday: "long",
				month: "long",
				day: "numeric",
			}) +
			"</button>"
		: "";
	scheduleList.innerHTML =
		CARD +
		' text-stone-warm">' +
		'<p class="text-stone-warm text-sm sm:text-base">' +
		msg +
		"</p>" +
		btn +
		"</div>";
	const b = $("nextAvailable");
	b?.addEventListener("click", () => {
		state.selected = new Date(`${b.getAttribute("data-date")}T00:00:00`);
		state.weekStart = startOfWeek(state.selected);
		renderDates();
		loadAll();
	});
}

function renderSchedule(s: ScheduleItem): string {
	const duration = s.duration ? `${s.duration} min` : "";
	const capacity = s.capacity != null ? s.capacity : "—";
	const barWidth =
		typeof s.capacity === "number"
			? Math.min(100, Math.max(10, s.capacity * 5))
			: 0;

	return (
		'<article class="bg-white rounded-[20px] sm:rounded-[24px] border border-sage-100 p-4 sm:p-5 mb-3 sm:mb-4 hover:shadow-lg transition overflow-hidden">' +
		'<div class="flex flex-col gap-4 md:flex-row md:items-center md:gap-5">' +
		'<div class="flex items-center gap-2.5 sm:gap-3 md:block md:w-[120px] shrink-0">' +
		'<div class="w-12 h-12 sm:w-auto sm:h-auto shrink-0 grid place-items-center md:block rounded-xl bg-sage-50 md:bg-transparent">' +
		'<div class="text-base sm:text-xl font-bold leading-tight">' +
		escapeHtml(s.start_time) +
		"</div></div>" +
		'<div class="min-w-0">' +
		'<div class="text-[13px] sm:text-sm text-stone-warm truncate">' +
		escapeHtml(s.end_time || "—") +
		(duration ? ` · ${escapeHtml(duration)}` : "") +
		"</div></div></div>" +
		'<div class="flex-1 min-w-0">' +
		'<div class="flex flex-wrap items-center gap-1.5 sm:gap-2 mb-1.5 sm:mb-2">' +
		'<span class="px-2.5 py-1 rounded-full bg-sage-50 text-sage-700 text-[11px] sm:text-xs font-semibold">' +
		escapeHtml(capitalize(s.class?.level)) +
		"</span>" +
		'<span class="px-2.5 py-1 rounded-full bg-stone-50 text-stone-warm text-[11px] sm:text-xs">' +
		escapeHtml(timeLabel(s.start_time)) +
		"</span></div>" +
		'<h3 class="text-[17px] sm:text-lg font-bold leading-snug">' +
		escapeHtml(s.class?.name) +
		"</h3>" +
		'<p class="text-[13px] sm:text-sm text-stone-warm mt-1 line-clamp-2">' +
		escapeHtml(s.class?.description || "") +
		"</p>" +
		'<div class="flex flex-wrap gap-x-4 sm:gap-x-5 gap-y-1 mt-2.5 sm:mt-3 text-[13px] sm:text-sm text-stone-warm">' +
		'<span class="inline-flex items-center gap-1.5 min-w-0 max-w-full"><span class="truncate">' +
		escapeHtml(s.instructor?.name || "—") +
		"</span></span>" +
		'<span class="inline-flex items-center gap-1.5 min-w-0 max-w-full"><span class="truncate">' +
		escapeHtml(s.studio?.name || "—") +
		"</span></span></div></div>" +
		'<div class="flex sm:items-center gap-3 md:block md:w-[150px] shrink-0 border-t border-sage-50 md:border-0 pt-3.5 md:pt-0">' +
		'<div class="flex-1 md:flex-none min-w-0">' +
		'<div class="text-[13px] sm:text-sm font-semibold truncate">' +
		escapeHtml(capacity) +
		" spots capacity</div>" +
		'<div class="w-full h-1.5 bg-stone-100 rounded-full mt-2">' +
		'<div class="h-1.5 bg-sage-600 rounded-full" style="width: ' +
		barWidth +
		'%"></div></div></div>' +
		'<a href="#" data-action="open-booking" class="shrink-0 inline-flex items-center justify-center md:w-full md:mt-3 bg-sage-700 text-white rounded-full px-5 min-h-[44px] py-2.5 text-sm font-semibold hover:bg-sage-800 active:bg-sage-900 transition">Book</a>' +
		"</div>" +
		"</div></article>"
	);
}

function renderSchedules(list: ScheduleItem[]) {
	if (!scheduleList) return;
	if (scheduleTitle) {
		scheduleTitle.textContent = state.selected.toLocaleDateString("en-US", {
			weekday: "long",
			month: "long",
			day: "numeric",
		});
	}
	if (scheduleCount) {
		scheduleCount.textContent = `${list.length + (list.length === 1 ? " class" : " classes")} available`;
	}

	const active: string[] = [];
	if (state.level) active.push(capitalize(state.level));
	if (state.time) active.push(capitalize(state.time));
	if (state.studio) {
		const st = document.querySelector<HTMLInputElement>(
			`[data-filter-group="studio"] input[value="${state.studio}"]`,
		);
		active.push(st?.closest("label")?.querySelector("span")?.textContent || "");
	}
	if (scheduleFilterNote) {
		scheduleFilterNote.textContent = active.length
			? `Filtered: ${active.join(", ")}`
			: "Showing all classes";
	}

	if (!list.length) {
		scheduleList.innerHTML =
			CARD +
			' text-stone-warm text-sm sm:text-base">Checking upcoming days...</div>';
		emptyState();
		return;
	}

	scheduleList.innerHTML = list.map(renderSchedule).join("");
}

function syncFilterDot() {
	const dot = $("filterActiveDot");
	if (!dot) return;
	dot.classList.toggle("hidden", !(state.level || state.time || state.studio));
}

async function loadSchedules() {
	if (!scheduleList) return;
	syncFilterDot();
	scheduleList.innerHTML = `${CARD} text-stone-warm text-sm sm:text-base">Loading classes...</div>`;
	try {
		let params = `?date=${fmtISO(state.selected)}&per_page=50`;
		if (state.level) params += `&level=${encodeURIComponent(state.level)}`;
		if (state.time) params += `&time=${encodeURIComponent(state.time)}`;
		if (state.studio)
			params += `&studio_uuid=${encodeURIComponent(state.studio)}`;
		renderSchedules(await fetchJSON(`/api/class-schedules${params}`));
	} catch {
		scheduleList.innerHTML =
			CARD +
			' text-terracotta-600 text-sm sm:text-base">Failed to load classes. Please try again.</div>';
	}
}

function loadAll() {
	loadStudios();
	loadSchedules();
}

/* ---------- mobile filter toggle ---------- */

(() => {
	const toggle = $("filterToggle");
	const aside = $("filterAside");
	const chevron = $("filterChevron");
	if (!toggle || !aside) return;
	toggle.addEventListener("click", () => {
		const isHidden = aside.classList.contains("hidden");
		aside.classList.toggle("hidden", !isHidden);
		toggle.setAttribute("aria-expanded", isHidden ? "true" : "false");
		if (chevron) chevron.style.transform = isHidden ? "rotate(180deg)" : "";
		if (isHidden)
			aside.scrollIntoView({ behavior: "smooth", block: "nearest" });
	});
})();

bindGroup("level");
bindGroup("time");
bindGroup("studio");

renderDates();
loadAll();
