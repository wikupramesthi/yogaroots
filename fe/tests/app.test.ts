import request from "supertest";
import { beforeEach, describe, expect, it, vi } from "vitest";

/* ---------- mock semua service agar test tidak menyentuh backend ---------- */

vi.mock("../src/services/siteIdentityService.js", () => ({
	resolveSite: () => ({
		name: "YogaRoots",
		tagline: "Yoga, Meditation & Wellness",
		description: "Deskripsi uji.",
		address: "Jl. Uji",
		phone: "0812",
		email: "uji@example.com",
	}),
}));

vi.mock("../src/services/articleService.js", () => ({
	getArticles: async () => [],
	getArticle: async () => null,
}));

vi.mock("../src/services/bannerService.js", () => ({
	getBanners: async () => [],
}));

vi.mock("../src/services/classService.js", () => ({
	getClasses: async () => [],
	getClass: async () => null,
}));

vi.mock("../src/services/classScheduleService.js", () => ({
	getClassSchedules: async () => [],
	getClassSchedule: async () => null,
}));

const CAPTCHA = {
	captcha_id: "cf4e35eb-36da-4de1-b0d9-4f36d3a618d8",
	question: "How much is the result of 5 + 12?",
};

vi.mock("../src/services/contactService.js", () => ({
	getContactCaptcha: async () => CAPTCHA,
	sendContact: async () => ({ message: "Message sent successfully." }),
}));

const EVENTS_PAGE = {
	items: [{ judul: "Event Uji", deskripsi: "<p>ok</p>" }],
	currentPage: 2,
	lastPage: 5,
	perPage: 10,
	total: 42,
};

const getEventsPaginated = vi.fn(async () => EVENTS_PAGE);

vi.mock("../src/services/eventService.js", () => ({
	getEvents: vi.fn(async () => []),
	getEventsPaginated: (params: Record<string, unknown>) =>
		getEventsPaginated(params),
	getEvent: vi.fn(async () => null),
}));

vi.mock("../src/services/faqService.js", () => ({
	getFaqs: vi.fn(async () => []),
}));

vi.mock("../src/services/instructorService.js", () => ({
	getInstructors: vi.fn(async () => []),
}));

const PACKAGES_PAGE = {
	items: [{ uuid: "p1", name: "Paket Uji", slug: "paket-uji", options: [] }],
	currentPage: 1,
	lastPage: 3,
	perPage: 10,
	total: 25,
};

const getPackagesPaginated = vi.fn(async () => PACKAGES_PAGE);

vi.mock("../src/services/packageService.js", () => ({
	getPackages: vi.fn(async () => []),
	getPackagesPaginated: (params: Record<string, unknown>) =>
		getPackagesPaginated(params),
	getPackage: vi.fn(async () => null),
}));

vi.mock("../src/services/pageService.js", () => ({
	getPage: async () => null,
}));

vi.mock("../src/services/siteStatsService.js", () => ({
	getSiteStats: async () => null,
	formatStatCount: (v: unknown) => String(v ?? 0),
}));

vi.mock("../src/services/testimonialService.js", () => ({
	getTestimonials: async () => [],
}));

const { createApp } = await import("../src/app.js");

const app = createApp();

beforeEach(() => {
	vi.clearAllMocks();
});

/* ------------------------------ health ------------------------------ */

describe("health", () => {
	it("GET /healthz hidup tanpa memanggil backend", async () => {
		const res = await request(app).get("/healthz");
		expect(res.status).toBe(200);
		expect(res.body.status).toBe("ok");
		expect(res.headers["cache-control"]).toBe("no-store");
	});
});

/* --------------------------- security headers -------------------------- */

describe("security headers", () => {
	// Catatan: /healthz & /readyz di-mount sebelum cspNonce/securityHeaders
	// (src/app.ts), jadi endpoint liveness itu memang tanpa CSP.
	it("menyembunyikan x-powered-by", async () => {
		const res = await request(app).get("/healthz");
		expect(res.headers["x-powered-by"]).toBeUndefined();
	});

	it("halaman publik memakai CSP ketat dengan nonce", async () => {
		const res = await request(app).get("/about");
		const csp = res.headers["content-security-policy"];
		expect(csp).toBeDefined();
		expect(csp).toContain("script-src");
		expect(csp).toMatch(/script-src[^;]*'nonce-/);
		expect(csp).not.toMatch(/script-src[^;]*'unsafe-inline'/);
		expect(csp).toMatch(/script-src-attr 'none'/);
		expect(csp).toContain("frame-ancestors 'none'");
		expect(csp).toContain("object-src 'none'");
	});

	it("nonce di CSP sama dengan nonce di tag <script>", async () => {
		const res = await request(app).get("/about");
		const cspNonce = /'nonce-([^']+)'/.exec(
			res.headers["content-security-policy"],
		)?.[1];
		expect(cspNonce).toBeTruthy();
		expect(res.text).toContain(`nonce="${cspNonce}"`);
	});

	it("nonce berbeda tiap request", async () => {
		const grab = (csp: string) => /'nonce-([^']+)'/.exec(csp)?.[1];
		const a = await request(app).get("/about");
		const b = await request(app).get("/about");
		expect(grab(a.headers["content-security-policy"])).toBeTruthy();
		expect(grab(a.headers["content-security-policy"])).not.toBe(
			grab(b.headers["content-security-policy"]),
		);
	});
});

/* ------------------------------- robots ------------------------------- */

describe("robots.txt", () => {
	it("menyertakan directive Sitemap", async () => {
		const res = await request(app).get("/robots.txt");
		expect(res.status).toBe(200);
		expect(res.text).toMatch(/Sitemap:\s*http/i);
	});
});

/* ------------------------------ /api/contact ---------------------------- */

describe("POST /api/contact", () => {
	const valid = {
		nama: "Budi",
		email: "budi@example.com",
		no_telp: "081234567890",
		isi: "Halo",
		captcha_id: CAPTCHA.captcha_id,
		captcha_answer: "17",
	};

	it("menolak request lintas origin (CSRF)", async () => {
		const res = await request(app)
			.post("/api/contact")
			.set("Origin", "https://evil.test")
			.send(valid);
		expect(res.status).toBe(403);
	});

	it("menolak payload tidak valid dengan 400", async () => {
		const res = await request(app).post("/api/contact").send({ nama: "" });
		expect(res.status).toBe(400);
		expect(res.body.success).toBe(false);
	});

	it("menerima payload valid", async () => {
		const res = await request(app).post("/api/contact").send(valid);
		expect(res.status).toBe(200);
		expect(res.body.success).toBe(true);
	});
});

describe("GET /api/contact/captcha", () => {
	it("mengembalikan captcha dan tanpa cache", async () => {
		const res = await request(app).get("/api/contact/captcha");
		expect(res.status).toBe(200);
		expect(res.body.captcha_id).toBe(CAPTCHA.captcha_id);
		expect(res.headers["cache-control"]).toBe("no-store");
	});
});

/* ------------------- endpoint yang belum diimplementasi ------------------ */

describe("endpoint belum tersedia", () => {
	it("POST /api/booking membalas 501, bukan sukses palsu", async () => {
		const res = await request(app).post("/api/booking").send({
			name: "Budi",
			email: "budi@example.com",
			kelas: "Hatha",
		});
		expect(res.status).toBe(501);
		expect(res.body.success).toBe(false);
	});

	it("POST /api/booking tetap 400 bila payload tidak valid", async () => {
		const res = await request(app).post("/api/booking").send({ name: "" });
		expect(res.status).toBe(400);
	});

	it("POST /api/newsletter membalas 501, bukan sukses palsu", async () => {
		const res = await request(app)
			.post("/api/newsletter")
			.send({ email: "a@b.co" });
		expect(res.status).toBe(501);
		expect(res.body.success).toBe(false);
	});
});

/* ------------------------------ pagination ----------------------------- */

describe("pagination dari meta backend", () => {
	it("/packages memakai totalPages dari backend, bukan hardcode", async () => {
		const res = await request(app).get("/packages");
		expect(res.status).toBe(200);
		// mock: last_page = 3, current_page = 1 -> nav harus tampil
		expect(res.text).toContain('aria-label="Pagination"');
		expect(res.text).toMatch(/aria-current="page"[^>]*>\s*1\s*</);
		expect(res.text).toContain("page=2");
		expect(res.text).toContain("page=3");
	});

	it("/packages meneruskan page ke query backend", async () => {
		await request(app).get("/packages?page=2&sort=lowest_price");
		expect(getPackagesPaginated).toHaveBeenCalledWith(
			expect.objectContaining({ page: 2, sort: "lowest_price", per_page: 10 }),
		);
	});

	it("/event memakai totalPages dari backend", async () => {
		const res = await request(app).get("/event");
		expect(res.status).toBe(200);
		// mock: current_page = 2, last_page = 5
		expect(res.text).toContain('aria-label="Pagination"');
		expect(res.text).toMatch(/aria-current="page"[^>]*>\s*2\s*</);
		expect(res.text).toContain("page=5");
	});

	it("/event meneruskan page ke query backend", async () => {
		await request(app).get("/event?page=3");
		expect(getEventsPaginated).toHaveBeenCalledWith(
			expect.objectContaining({ page: 3, per_page: 10 }),
		);
	});
});

/* ------------------------- pageScript wiring ------------------------- */

describe("pageScript wiring", () => {
	it("halaman dengan island memuat loader bundle", async () => {
		const cases: [string, string][] = [
			["/classes", "classes"],
			["/schedules", "schedules"],
			["/contact", "contact"],
			["/blog", "blog"],
			["/", "home"],
		];
		for (const [path, name] of cases) {
			const res = await request(app).get(path);
			expect(res.status, path).toBe(200);
			expect(res.text, `${path} harus memuat pages/${name}.js`).toContain(
				`/js/pages/${name}.js`,
			);
		}
	});

	it("halaman tanpa island tidak memuat loader halaman", async () => {
		const res = await request(app).get("/about");
		expect(res.status).toBe(200);
		expect(res.text).not.toContain("/js/pages/");
	});
});

/* --------------------------- CSP regression -------------------------- */

describe("regresi CSP: tidak ada inline script tanpa nonce", () => {
	it("halaman yang dulu punya inline script tetap aman", async () => {
		for (const path of ["/", "/classes", "/schedules", "/blog", "/contact"]) {
			const res = await request(app).get(path);
			const scripts = [...res.text.matchAll(/<script\b([^>]*)>/gi)];
			for (const [, attrs] of scripts) {
				if (/src=/.test(attrs)) continue; // external 'self' diizinkan
				if (/type=["']?application\/(ld\+)?json/i.test(attrs)) continue;
				expect(attrs, `inline script tanpa nonce di ${path}`).toMatch(/nonce=/);
			}
		}
	});
});

/* ------------------------------- 404 --------------------------------- */

describe("not found", () => {
	it("halaman tak dikenal merender 404", async () => {
		const res = await request(app).get("/halaman-yang-tidak-ada-xyz");
		expect(res.status).toBe(404);
	});

	it("API tak dikenal membalas JSON 404", async () => {
		const res = await request(app).get("/api/entah");
		expect(res.status).toBe(404);
	});
});
