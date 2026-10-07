/**
 * YogaRoots theme interactions (dimuat di semua halaman).
 * Kode khusus halaman ada di src/browser/pages/<nama>.ts.
 *
 *   1. Navbar (mobile drawer, efek scroll, dropdown bahasa)
 *   2. Modal booking (data-action="open-booking" / "close-booking" + Escape)
 *   3. Reveal on scroll
 *   4. Fallback gambar (data-fallback, data-remove-on-error)
 */

import { $, lockScroll, onAction, unlockScroll } from "./lib/dom";

/* ---------- 1. navbar ---------- */

(() => {
	$("mobileBtn")?.addEventListener("click", () =>
		$("mobileNav")?.classList.toggle("hidden"),
	);

	const navbar = $("navbar");
	if (navbar) {
		const pill = navbar.querySelector("nav");
		const alwaysSolid = navbar.dataset.static === "true";
		const update = () => {
			const scrolled = alwaysSolid || window.scrollY > 40;
			navbar.classList.toggle("scrolled", scrolled);
			pill?.classList.toggle("glass-panel-strong", scrolled);
		};
		window.addEventListener("scroll", update, { passive: true });
		update();
	}

	const toggle = $("langToggle");
	const menu = $("langDropdown");
	if (toggle && menu) {
		toggle.addEventListener("click", (e) => {
			e.stopPropagation();
			menu.classList.toggle("hidden");
		});
		document.addEventListener("click", (e) => {
			if (
				!menu.classList.contains("hidden") &&
				!toggle.contains(e.target as Node)
			) {
				menu.classList.add("hidden");
			}
		});
	}
})();

/* ---------- 2. modal booking ---------- */

function openBooking() {
	const m = $("bookingModal");
	if (!m) return;
	m.classList.remove("hidden");
	lockScroll();
}

function closeBooking() {
	$("bookingModal")?.classList.add("hidden");
	unlockScroll();
}

function openEvent(index: number) {
	const modal = $("eventModal");
	if (!modal) return;
	const dataEl = $("eventsData");
	if (!dataEl) return;
	try {
		const events = JSON.parse(dataEl.textContent || "[]");
		const event = events[index];
		if (!event) return;
		modal.classList.remove("hidden");
		lockScroll();
	} catch {
		/* ignore */
	}
}

function closeEvent() {
	$("eventModal")?.classList.add("hidden");
	unlockScroll();
}

onAction({
	"open-booking": openBooking,
	"close-booking": closeBooking,
	"open-event": (el) => {
		const index = parseInt(el.dataset.index || "0", 10);
		openEvent(index);
	},
	"close-event": closeEvent,
});

document.addEventListener("keydown", (ev) => {
	if (ev.key === "Escape") closeBooking();
});

/* ---------- 3. reveal on scroll ---------- */

(() => {
	const els = document.querySelectorAll(".reveal");
	if (!("IntersectionObserver" in window) || !els.length) {
		els.forEach((el) => {
			el.classList.add("reveal-show");
		});
		return;
	}
	const io = new IntersectionObserver(
		(entries) => {
			entries.forEach((ent) => {
				if (!ent.isIntersecting) return;
				const target = ent.target as HTMLElement;
				target.classList.remove("reveal-hide");
				target.classList.add("reveal-show");
				const delay = parseInt(target.dataset.delay || "0", 10);
				setTimeout(() => {
					target.style.transitionDelay = "";
				}, 850 + delay);
				io.unobserve(ent.target);
			});
		},
		{ threshold: 0.12, rootMargin: "0px 0px -8% 0px" },
	);
	els.forEach((el) => {
		const target = el as HTMLElement;
		target.classList.add("reveal-hide");
		if (target.dataset.delay)
			target.style.transitionDelay = `${target.dataset.delay}ms`;
		io.observe(el);
	});
})();

/* ---------- 4. fallback gambar ---------- */

function handleImageError(img: HTMLImageElement) {
	const fb = img.dataset.fallback;
	if (fb) {
		if (img.getAttribute("src") !== fb && !img.dataset.fbk) {
			img.dataset.fbk = "1";
			img.src = fb;
		}
		return;
	}
	if (img.dataset.removeOnError === undefined) return;

	const unclass = img.dataset.errorRemoveClass;
	if (unclass) {
		img
			.closest(img.dataset.errorClassTarget || "body")
			?.classList.remove(unclass);
	}
	const selector = img.dataset.removeOnError;
	(selector ? img.closest(selector) : img)?.remove();
}

function handleImageErrorAttr(img: HTMLImageElement) {
	const action = img.dataset.imgError;
	if (!action) return;
	if (action === "remove") {
		img.remove();
	} else if (action === "closest-figure") {
		img.closest("figure")?.remove();
	} else if (action === "parent-remove") {
		img.closest(".grid")?.classList.remove("lg:grid-cols-2");
		img.parentElement?.remove();
	}
}

document.addEventListener(
	"error",
	(e) => {
		if (!(e.target instanceof HTMLImageElement)) return;
		if (e.target.dataset.imgError) {
			handleImageErrorAttr(e.target);
		} else {
			handleImageError(e.target);
		}
	},
	true,
);

// Gambar yang sudah gagal dimuat sebelum script ini jalan tidak memicu event lagi.
document
	.querySelectorAll<HTMLImageElement>(
		"img[data-fallback], img[data-remove-on-error], img[data-img-error]",
	)
	.forEach((img) => {
		if (img.complete && img.naturalWidth === 0 && img.getAttribute("src")) {
			if (img.dataset.imgError) {
				handleImageErrorAttr(img);
			} else {
				handleImageError(img);
			}
		}
	});
