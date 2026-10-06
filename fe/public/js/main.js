// @ts-nocheck
/**
 * YogaRoots theme interactions.
 * Setiap blok dijaga oleh elemennya masing-masing — aman di semua halaman.
 *
 *   1. Navbar (mobile drawer, efek scroll, dropdown bahasa)
 *   2. Modal (booking/login, event + tombol Escape)
 *   3. Form kontak (fetch JSON + status pesan)
 *   4. FAQ accordion
 *   5. Lightbox galeri
 *   6. Reveal on scroll
 *   7. Fallback gambar backend yang 404
 */
"use strict";
/* ---------- utils ---------- */
const $ = (id) => document.getElementById(id);
function escapeHtml(s) {
    return String(s ?? "")
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#x27;");
}
async function postJSON(url, body) {
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
function lockScroll() {
    document.body.style.overflow = "hidden";
}
function unlockScroll() {
    const anyOpen = ["bookingModal", "eventModal"].some((id) => $(id) && !$(id).classList.contains("hidden"));
    if (!anyOpen)
        document.body.style.overflow = "";
}
/* ---------- 1. navbar ---------- */
(() => {
    $("mobileBtn")?.addEventListener("click", () => $("mobileNav")?.classList.toggle("hidden"));
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
            if (!menu.classList.contains("hidden") && !toggle.contains(e.target)) {
                menu.classList.add("hidden");
            }
        });
    }
})();
/* ---------- 2. modal ---------- */
window.openBooking = () => {
    const m = $("bookingModal");
    if (!m)
        return false;
    m.classList.remove("hidden");
    lockScroll();
    return false;
};
window.closeBooking = () => {
    $("bookingModal")?.classList.add("hidden");
    unlockScroll();
};
const eventModal = $("eventModal");
let eventsData = [];
try {
    const raw = $("eventsData")?.textContent || "[]";
    const parsed = JSON.parse(raw);
    if (Array.isArray(parsed))
        eventsData = parsed;
}
catch {
    eventsData = [];
}
const META_ICONS = {
    date: '<path d="M8 3v4m8-4v4M4 9h16M6 5h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2z"></path>',
    time: '<circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 2"></path>',
    place: '<path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle>',
};
function metaItem(icon, text) {
    return ('<span class="flex items-center gap-1.5">' +
        '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' +
        icon +
        "</svg>" +
        escapeHtml(text) +
        "</span>");
}
window.openEvent = (i) => {
    const e = eventsData[i];
    if (!e || !eventModal)
        return;
    $("eventTitle").textContent = e.judul || "";
    let html = "";
    if (e.tanggal)
        html += metaItem(META_ICONS.date, e.tanggal);
    if (e.waktu_mulai) {
        const range = String(e.waktu_mulai).substring(0, 5) +
            (e.waktu_selesai ? " - " + String(e.waktu_selesai).substring(0, 5) : "");
        html += metaItem(META_ICONS.time, range);
    }
    if (e.lokasi)
        html += metaItem(META_ICONS.place, e.lokasi);
    $("eventMeta").innerHTML = html;
    // Deskripsi dari CMS backend (sudah disanitasi server-side bila lewat JSON ini).
    $("eventDesc").innerHTML = e.deskripsi || "";
    const wa = $("eventWhatsApp");
    // No hardcoded WA number — base wajib dari server via data-wa-base (contactLinks).
    if (e.judul && wa && wa.dataset.waBase) {
        const base = wa.dataset.waBase;
        wa.href =
            base + "?text=" + encodeURIComponent("Hi, I want to book a spot for: " + e.judul);
    }
    eventModal.classList.remove("hidden");
    lockScroll();
};
window.closeEvent = () => {
    eventModal?.classList.add("hidden");
    unlockScroll();
};
document.addEventListener("keydown", (ev) => {
    if (ev.key === "Escape") {
        window.closeEvent();
        window.closeBooking();
    }
});
/* ---------- 3. form kontak ---------- */
(() => {
    const form = $("contactForm");
    if (!form)
        return;
    const button = form.querySelector("button");
    const message = $("contactMsg");
    const idleLabel = button ? button.textContent : "";
    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        if (button) {
            button.disabled = true;
            button.textContent = form.dataset.sending || "Sending...";
        }
        try {
            const result = await postJSON("/api/contact", Object.fromEntries(new FormData(form).entries()));
            message.className = "text-sm p-3 rounded-xl bg-green-50 text-green-700";
            message.textContent = result.message;
            message.classList.remove("hidden");
            form.reset();
        }
        catch (err) {
            message.className = "text-sm p-3 rounded-xl bg-red-50 text-red-700";
            message.textContent = err.message;
            message.classList.remove("hidden");
        }
        finally {
            if (button) {
                button.disabled = false;
                button.textContent = idleLabel;
            }
        }
    });
})();
/* ---------- 4. FAQ accordion ---------- */
document.querySelectorAll("[data-faq]").forEach((btn) => {
    btn.addEventListener("click", () => {
        const content = btn.nextElementSibling;
        const willOpen = content.classList.contains("hidden");
        document
            .querySelectorAll("[data-faq] + div")
            .forEach((d) => d.classList.add("hidden"));
        if (willOpen)
            content.classList.remove("hidden");
    });
});
/* ---------- 5. lightbox galeri ---------- */
let lightboxImgs = [];
window.openLightbox = (src, idx) => {
    lightboxImgs = Array.from(document.querySelectorAll("[data-gallery]")).map((img) => img.src);
    const lb = $("lightbox");
    if (!lb)
        return;
    // Cari indeks dari src (aman walau sebagian gambar gagal dimuat & terhapus)
    let at = parseInt(idx, 10);
    if (!Number.isInteger(at) || lightboxImgs[at] !== src) {
        at = lightboxImgs.indexOf(src);
    }
    lb.querySelector("img").src = src;
    lb.classList.remove("hidden");
    lb.dataset.idx = at >= 0 ? at : 0;
};
window.closeLightbox = () => $("lightbox")?.classList.add("hidden");
window.lightboxNav = (dir) => {
    const lb = $("lightbox");
    if (!lb || !lightboxImgs.length)
        return;
    let idx = (parseInt(lb.dataset.idx || "0", 10) + dir) % lightboxImgs.length;
    if (idx < 0)
        idx += lightboxImgs.length;
    lb.dataset.idx = idx;
    lb.querySelector("img").src = lightboxImgs[idx];
};
/* ---------- 6. reveal on scroll ---------- */
(() => {
    const els = document.querySelectorAll(".reveal");
    if (!("IntersectionObserver" in window) || !els.length) {
        els.forEach((el) => el.classList.add("reveal-show"));
        return;
    }
    const io = new IntersectionObserver((entries) => {
        entries.forEach((ent) => {
            if (!ent.isIntersecting)
                return;
            ent.target.classList.remove("reveal-hide");
            ent.target.classList.add("reveal-show");
            const delay = parseInt(ent.target.dataset.delay || "0", 10);
            setTimeout(() => {
                ent.target.style.transitionDelay = "";
            }, 850 + delay);
            io.unobserve(ent.target);
        });
    }, { threshold: 0.12, rootMargin: "0px 0px -8% 0px" });
    els.forEach((el) => {
        el.classList.add("reveal-hide");
        if (el.dataset.delay)
            el.style.transitionDelay = el.dataset.delay + "ms";
        io.observe(el);
    });
})();
/* ---------- 7. fallback gambar ---------- */
document.querySelectorAll("img[data-fallback]").forEach((img) => {
    img.addEventListener("error", () => {
        const fb = img.getAttribute("data-fallback");
        if (fb && img.src !== fb && !img.dataset.fbk) {
            img.dataset.fbk = "1";
            img.src = fb;
        }
    });
});
