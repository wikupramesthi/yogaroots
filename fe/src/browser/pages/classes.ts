export {};

const search = document.getElementById(
	"classSearch",
) as HTMLInputElement | null;
const pills = Array.from(document.querySelectorAll<HTMLElement>(".level-pill"));
const cards = Array.from(document.querySelectorAll<HTMLElement>(".class-card"));
const empty = document.getElementById("classEmpty");
let activeLevel = "";

function applyFilter() {
	const q = (search?.value || "").trim().toLowerCase();
	let shown = 0;
	cards.forEach((card) => {
		const okLevel =
			!activeLevel || card.getAttribute("data-level") === activeLevel;
		const hay =
			(card.getAttribute("data-name") || "") +
			" " +
			(card.getAttribute("data-desc") || "");
		const okSearch = !q || hay.indexOf(q) !== -1;
		const show = okLevel && okSearch;
		card.style.display = show ? "" : "none";
		if (show) shown++;
	});
	empty?.classList.toggle("hidden", shown > 0);
}

search?.addEventListener("input", applyFilter);

pills.forEach((pill) => {
	pill.addEventListener("click", () => {
		activeLevel = pill.getAttribute("data-level") || "";
		pills.forEach((p) => {
			const on = p === pill;
			p.classList.toggle("bg-sage-700", on);
			p.classList.toggle("text-white", on);
			p.classList.toggle("bg-sage-50", !on);
			p.classList.toggle("text-sage-700", !on);
		});
		applyFilter();
	});
});
