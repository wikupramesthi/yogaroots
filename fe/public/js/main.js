// Mobile nav
const btn = document.getElementById("mobileBtn");
const drawer = document.getElementById("mobileNav");
if (btn && drawer)
  btn.addEventListener("click", () => drawer.classList.toggle("hidden"));

// Navbar scroll effect (transparent → glass panel past 40px)
// Inner pages stay in the "scrolled" glass state at all times
const navbar = document.getElementById("navbar");
if (navbar) {
  const navPill = navbar.querySelector("nav");
  const alwaysSolid = navbar.dataset.static === "true";
  const updateNavbar = () => {
    const scrolled = alwaysSolid || window.scrollY > 40;
    navbar.classList.toggle("scrolled", scrolled);
    if (scrolled) navPill?.classList.add("glass-panel-strong");
    else navPill?.classList.remove("glass-panel-strong");
  };
  window.addEventListener("scroll", updateNavbar, { passive: true });
  updateNavbar();
}

// Language dropdown
const langToggle = document.getElementById("langToggle");
const langDropdown = document.getElementById("langDropdown");
if (langToggle && langDropdown) {
  langToggle.addEventListener("click", (e) => {
    e.stopPropagation();
    langDropdown.classList.toggle("hidden");
  });
  document.addEventListener("click", (e) => {
    if (!langDropdown.classList.contains("hidden") && !langToggle.contains(e.target)) {
      langDropdown.classList.add("hidden");
    }
  });
}

// Booking modal
window.openBooking = (kelas = "") => {
  const m = document.getElementById("bookingModal");
  if (!m) return;
  m.classList.remove("hidden");
  if (kelas) {
    const s = m.querySelector("select[name=kelas]");
    if (s) s.value = kelas;
  }
};
window.closeBooking = () => {
  document.getElementById("bookingModal")?.classList.add("hidden");
};

// Event modal (homepage events data)
const eventsDataEl = document.getElementById("eventsData");
const eventsData = eventsDataEl ? JSON.parse(eventsDataEl.textContent || "[]") : [];
const eventModal = document.getElementById("eventModal");
window.openEvent = (i) => {
  const e = eventsData[i];
  if (!e || !eventModal) return;
  document.getElementById("eventTitle").textContent = e.judul || "";
  const meta = document.getElementById("eventMeta");
  let html = "";
  if (e.tanggal)
    html +=
      '<span class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3v4m8-4v4M4 9h16M6 5h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2z"></path></svg>' +
      e.tanggal +
      "</span>";
  if (e.waktu_mulai)
    html +=
      '<span class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 2"></path></svg>' +
      e.waktu_mulai.substring(0, 5) +
      (e.waktu_selesai ? " - " + e.waktu_selesai.substring(0, 5) : "") +
      "</span>";
  if (e.lokasi)
    html +=
      '<span class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg>' +
      e.lokasi +
      "</span>";
  meta.innerHTML = html;
  const desc = document.getElementById("eventDesc");
  desc.innerHTML = e.deskripsi || "";
  const wa = document.getElementById("eventWhatsApp");
  if (e.judul) wa.href = "https://wa.me/6281321221270?text=" + encodeURIComponent("Hi, I want to book a spot for: " + e.judul);
  eventModal.classList.remove("hidden");
  document.body.style.overflow = "hidden";
};
window.closeEvent = () => {
  eventModal?.classList.add("hidden");
  document.body.style.overflow = "";
};
document.addEventListener("keydown", (ev) => {
  if (ev.key === "Escape") {
    closeEvent();
    closeBooking();
  }
});

// Booking form
document
  .getElementById("bookingForm")
  ?.addEventListener("submit", async (e) => {
    e.preventDefault();
    const fd = new FormData(e.target);
    const body = Object.fromEntries(fd.entries());
    const msg = document.getElementById("bookingMsg");
    msg.className = "text-sm mt-3 p-3 rounded-xl bg-sage-50";
    msg.textContent = "Mengirim...";
    msg.classList.remove("hidden");
    try {
      const r = await fetch("/api/booking", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(body),
      });
      const j = await r.json();
      msg.textContent = j.message;
      msg.className =
        "text-sm mt-3 p-3 rounded-xl " +
        (j.success ? "bg-green-50 text-green-700" : "bg-red-50 text-red-700");
      if (j.success) e.target.reset();
    } catch {
      msg.textContent = "Gagal terhubung";
      msg.className = "text-sm mt-3 p-3 rounded-xl bg-red-50 text-red-700";
    }
  });

// Newsletter
document
  .getElementById("newsletterForm")
  ?.addEventListener("submit", async (e) => {
    e.preventDefault();
    const email = e.target.email.value;
    const msg = document.getElementById("newsletterMsg");
    try {
      const r = await fetch("/api/newsletter", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email }),
      });
      const j = await r.json();
      msg.textContent = j.message;
      msg.classList.remove("hidden");
      msg.className =
        "text-xs mt-2 " + (j.success ? "text-green-300" : "text-red-300");
    } catch {
      msg.textContent = "Gagal";
      msg.classList.remove("hidden");
    }
  });

// Contact form
const contactForm = document.getElementById("contactForm");

if (contactForm) {
  contactForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const button = contactForm.querySelector("button");
    const message = document.getElementById("contactMsg");

    button.disabled = true;
    button.textContent = "Mengirim...";

    try {
      const formData = new FormData(contactForm);

      const response = await fetch("/api/contact", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(Object.fromEntries(formData.entries())),
      });

      const result = await response.json();

      if (!response.ok) {
        throw new Error(result.message || "Gagal mengirim pesan");
      }

      message.className = "text-sm p-3 rounded-xl bg-green-50 text-green-700";

      message.textContent = result.message;
      message.classList.remove("hidden");

      contactForm.reset();
    } catch (error) {
      console.error("CONTACT ERROR:", error);

      message.className = "text-sm p-3 rounded-xl bg-red-50 text-red-700";

      message.textContent = error.message;
      message.classList.remove("hidden");
    } finally {
      button.disabled = false;
      button.textContent = "Kirim Pesan →";
    }
  });
}

// FAQ accordion
document.querySelectorAll("[data-faq]")?.forEach((btn) => {
  btn.addEventListener("click", () => {
    const content = btn.nextElementSibling;
    const isOpen = !content.classList.contains("hidden");
    document
      .querySelectorAll("[data-faq] + div")
      .forEach((d) => d.classList.add("hidden"));
    if (!isOpen) content.classList.remove("hidden");
  });
});

// Pricing toggle
const toggle = document.getElementById("pricingToggle");
if (toggle) {
  toggle.addEventListener("change", (e) => {
    document.querySelectorAll("[data-price]").forEach((el) => {
      const m = el.dataset.monthly,
        y = el.dataset.yearly;
      el.textContent = e.target.checked ? y : m;
    });
    document.querySelectorAll("[data-period]").forEach((el) => {
      el.textContent = e.target.checked ? "/tahun" : "/bulan";
    });
  });
}

// Category filter (classes page)
document.querySelectorAll("[data-filter]")?.forEach((a) => {
  a.addEventListener("click", (e) => {
    // allow normal navigation; fallback JS filter for same-page
  });
});

// Gallery lightbox
let lightboxImgs = [];
window.openLightbox = (src, idx) => {
  lightboxImgs = Array.from(document.querySelectorAll("[data-gallery]")).map(
    (i) => i.src,
  );
  const lb = document.getElementById("lightbox");
  if (!lb) return;
  lb.querySelector("img").src = src;
  lb.classList.remove("hidden");
  lb.dataset.idx = idx;
};
window.closeLightbox = () =>
  document.getElementById("lightbox")?.classList.add("hidden");
window.lightboxNav = (dir) => {
  const lb = document.getElementById("lightbox");
  let idx = parseInt(lb.dataset.idx || "0") + dir;
  if (idx < 0) idx = lightboxImgs.length - 1;
  if (idx >= lightboxImgs.length) idx = 0;
  lb.dataset.idx = idx;
  lb.querySelector("img").src = lightboxImgs[idx];
};

// Dark mode toggle
const darkBtn = document.getElementById("darkToggle");
function applyDark(isDark) {
  document.documentElement.classList.toggle("dark", isDark);
  try {
    localStorage.setItem("serene-dark", isDark);
  } catch (e) {}
  if (darkBtn) darkBtn.textContent = isDark ? "☀" : "◐";
}
if (darkBtn) {
  // init icon
  darkBtn.textContent = document.documentElement.classList.contains("dark")
    ? "☀"
    : "◐";
  darkBtn.addEventListener("click", () => {
    const isDark = !document.documentElement.classList.contains("dark");
    applyDark(isDark);
  });
}

// Reveal on scroll (stagger via data-delay, kannayoga easing)
const revealEls = document.querySelectorAll(".reveal");
function revealShow(el) {
  el.classList.remove("reveal-hide");
  el.classList.add("reveal-show");
  const delay = parseInt(el.dataset.delay || "0", 10);
  setTimeout(() => {
    el.style.transitionDelay = "";
  }, 850 + delay);
}
if ("IntersectionObserver" in window && revealEls.length) {
  const revealObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((ent) => {
        if (ent.isIntersecting) {
          revealShow(ent.target);
          revealObserver.unobserve(ent.target);
        }
      });
    },
    { threshold: 0.12, rootMargin: "0px 0px -8% 0px" }
  );
  revealEls.forEach((el) => {
    el.classList.add("reveal-hide");
    const d = el.dataset.delay;
    if (d) el.style.transitionDelay = d + "ms";
    revealObserver.observe(el);
  });
} else {
  // Fallback: show everything immediately
  revealEls.forEach((el) => el.classList.add("reveal-show"));
}
