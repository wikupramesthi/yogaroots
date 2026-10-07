import { $, onAction } from "../lib/dom";

let lightboxImgs: string[] = [];

function lightboxImage(lb: HTMLElement): HTMLImageElement | null {
	return lb.querySelector("img");
}

function openLightbox(src: string, idx: string | undefined) {
	lightboxImgs = Array.from(
		document.querySelectorAll<HTMLImageElement>("[data-gallery]"),
	).map((img) => img.src);
	const lb = $("lightbox");
	const target = lb && lightboxImage(lb);
	if (!lb || !target) return;
	// Cari indeks dari src (aman walau sebagian gambar gagal dimuat & terhapus)
	let at = parseInt(idx || "", 10);
	if (!Number.isInteger(at) || lightboxImgs[at] !== src) {
		at = lightboxImgs.indexOf(src);
	}
	target.src = src;
	lb.classList.remove("hidden");
	lb.dataset.idx = String(at >= 0 ? at : 0);
}

function closeLightbox() {
	$("lightbox")?.classList.add("hidden");
}

function lightboxNav(dir: number) {
	const lb = $("lightbox");
	const target = lb && lightboxImage(lb);
	if (!lb || !target || !lightboxImgs.length) return;
	let idx = (parseInt(lb.dataset.idx || "0", 10) + dir) % lightboxImgs.length;
	if (idx < 0) idx += lightboxImgs.length;
	lb.dataset.idx = String(idx);
	target.src = lightboxImgs[idx];
}

onAction({
	"open-lightbox": (el) =>
		openLightbox((el as HTMLImageElement).src, el.dataset.lightboxIndex),
	"close-lightbox": closeLightbox,
	"lightbox-nav": (el) => lightboxNav(parseInt(el.dataset.dir || "0", 10)),
});
