export {};

/* Daftar isi otomatis dari h2/h3 + penanda posisi baca */
(() => {
	const content = document.getElementById("legalContent");
	const toc = document.getElementById("tocList");
	if (!content || !toc) return;

	const headings = content.querySelectorAll<HTMLElement>("h2, h3");
	if (!headings.length) {
		const aside = toc.closest("aside");
		if (aside) aside.style.display = "none";
		return;
	}

	const slugify = (text: string) =>
		text
			.toLowerCase()
			.trim()
			.replace(/[^\w\s-]/g, "")
			.replace(/[\s_]+/g, "-")
			.replace(/-+/g, "-") || "section";

	const used: Record<string, number> = {};
	const links: HTMLAnchorElement[] = [];
	headings.forEach((h, i) => {
		const base = slugify(h.textContent || "") || `section-${i + 1}`;
		const n = used[base] || 0;
		used[base] = n + 1;
		const id = n ? `${base}-${n + 1}` : base;
		h.id = id;

		const li = document.createElement("li");
		const a = document.createElement("a");
		a.href = `#${id}`;
		a.textContent = (h.textContent || "").trim();
		a.className =
			"toc-link block rounded-lg px-3 py-1.5 text-stone-warm hover:bg-sage-50 hover:text-sage-800 transition-colors line-clamp-2";
		a.addEventListener("click", (e) => {
			e.preventDefault();
			document
				.getElementById(id)
				?.scrollIntoView({ behavior: "smooth", block: "start" });
			history.replaceState(null, "", `#${id}`);
		});
		li.appendChild(a);
		toc.appendChild(li);
		links.push(a);
	});

	const spy = () => {
		let current: string | null = null;
		headings.forEach((h) => {
			if (h.getBoundingClientRect().top <= 140) current = h.id;
		});
		links.forEach((a) => {
			const on = !!current && a.getAttribute("href") === `#${current}`;
			a.classList.toggle("bg-sage-700", on);
			a.classList.toggle("text-white", on);
			a.classList.toggle("text-stone-warm", !on);
		});
	};
	let ticking = false;
	window.addEventListener(
		"scroll",
		() => {
			if (!ticking) {
				window.requestAnimationFrame(() => {
					spy();
					ticking = false;
				});
				ticking = true;
			}
		},
		{ passive: true },
	);
	spy();
})();
