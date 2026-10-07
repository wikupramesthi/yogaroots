import request from "supertest";
import { beforeEach, describe, expect, it, vi } from "vitest";

/* ---------- mock service, backend tidak disentuh ---------- */

const USER = {
	uuid: "dd9d6231-c532-4e9e-a954-959fe814b3b9",
	name: "Budi Santoso",
	email: "budi@example.com",
	avatar: null,
	roles: ["user"],
};

const getSessionUser = vi.fn<(c?: string) => Promise<typeof USER | null>>();
const logoutSession = vi.fn<(c?: string) => Promise<boolean>>();

vi.mock("../src/services/authService.js", async () => {
	// Ikuti implementasi asli untuk hasSessionCookie (memakai env)
	const actual = await vi.importActual<
		typeof import("../src/services/authService.js")
	>("../src/services/authService.js");
	return {
		...actual,
		getSessionUser: (c?: string) => getSessionUser(c),
		logoutSession: (c?: string) => logoutSession(c),
	};
});

vi.mock("../src/services/siteIdentityService.js", () => ({
	resolveSite: () => ({
		name: "YogaRoots",
		tagline: "Yoga",
		description: "d",
		address: "a",
		phone: "p",
		email: "e@e.com",
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
vi.mock("../src/services/contactService.js", () => ({
	getContactCaptcha: async () => ({ captcha_id: "x", question: "y" }),
	sendContact: async () => ({ message: "ok" }),
}));
vi.mock("../src/services/eventService.js", () => ({
	getEvents: async () => [],
	getEventsPaginated: async () => ({
		items: [],
		currentPage: 1,
		lastPage: 1,
		perPage: 10,
		total: 0,
	}),
	getEvent: async () => null,
}));
vi.mock("../src/services/faqService.js", () => ({ getFaqs: async () => [] }));
vi.mock("../src/services/instructorService.js", () => ({
	getInstructors: async () => [],
}));
vi.mock("../src/services/packageService.js", () => ({
	getPackages: async () => [],
	getPackagesPaginated: async () => ({
		items: [],
		currentPage: 1,
		lastPage: 1,
		perPage: 10,
		total: 0,
	}),
	getPackage: async () => null,
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

// Cache session di locals.ts bertahan antar test, jadi harus dikosongkan
// setiap kali mock berubah — kalau tidak, test kedua ikut memakai hasil pertama.
const { clearSessionCache } = await import("../src/middleware/locals.js");
const { createApp } = await import("../src/app.js");
const app = createApp();

/** Selalu bersihkan cache sebelum ganti state mock. */
function setSession(result: typeof USER | null) {
	clearSessionCache();
	getSessionUser.mockResolvedValue(result);
}

const SESSION = "laravel_session=abcdef123456";

beforeEach(() => {
	vi.clearAllMocks();
	clearSessionCache();
});

/* ============================ anonim ============================ */

describe("state anonim (belum login)", () => {
	it("tidak memanggil backend bila tidak ada cookie session", async () => {
		await request(app).get("/");
		expect(getSessionUser).not.toHaveBeenCalled();
	});

	it("menampilkan tombol Google di modal", async () => {
		const res = await request(app).get("/");
		expect(res.text).toContain('id="googleLoginBtn"');
		expect(res.text).toContain("Begin Your Practice");
	});

	it("tidak menampilkan dropdown user", async () => {
		const res = await request(app).get("/");
		expect(res.text).not.toContain('id="userMenu"');
		expect(res.text).not.toContain('data-action="logout"');
	});

	it("link Google membawa redirect ke FE", async () => {
		const res = await request(app).get("/");
		const href = /href="([^"]*auth\/google[^"]*)"/.exec(res.text)?.[1] || "";
		expect(href).toContain("redirect=");
		expect(decodeURIComponent(href)).toContain("localhost:3000");
	});
});

/* ============================ sudah login ============================ */

describe("state login", () => {
	beforeEach(() => {
		setSession(USER);
	});

	it("cookie session diteruskan ke authService apa adanya", async () => {
		await request(app).get("/").set("Cookie", `${SESSION}; locale=id`);
		expect(getSessionUser).toHaveBeenCalledWith(`${SESSION}; locale=id`);
	});

	it("navbar menampilkan dropdown user, bukan tombol Login", async () => {
		const res = await request(app).get("/").set("Cookie", SESSION);
		expect(res.text).toContain('id="userMenu"');
		expect(res.text).toContain('id="userMenuBtn"');
		expect(res.text).toContain("Budi Santoso");
		expect(res.text).toContain("budi@example.com");
		expect(res.text).toContain('data-action="logout"');
	});

	it("modal menampilkan state login, bukan tombol Google", async () => {
		const res = await request(app).get("/").set("Cookie", SESSION);
		expect(res.text).toContain("Welcome back");
		expect(res.text).not.toContain('id="googleLoginBtn"');
		expect(res.text).toContain('href="/schedules"');
	});

	it("memakai inisial sebagai avatar cadangan", async () => {
		const res = await request(app).get("/").set("Cookie", SESSION);
		// 'B' dari "Budi Santoso"
		expect(res.text).toMatch(/>B</);
	});

	it("semua halaman konsisten menampilkan login", async () => {
		for (const p of ["/", "/classes", "/packages", "/contact", "/blog"]) {
			const res = await request(app).get(p).set("Cookie", SESSION);
			expect(res.text, p).toContain('id="userMenu"');
		}
	});

	it("tanpa 'undefined' di halaman mana pun", async () => {
		for (const p of ["/", "/classes", "/packages", "/contact", "/blog"]) {
			const res = await request(app).get(p).set("Cookie", SESSION);
			expect(res.text, p).not.toContain(">undefined<");
		}
	});
});

/* ============================ backend mati ============================ */

describe("ketika backend session tidak merespons", () => {
	it("halaman tetap render (fail-open ke anonim)", async () => {
		setSession(null);
		const res = await request(app).get("/").set("Cookie", SESSION);
		expect(res.status).toBe(200);
		expect(res.text).toContain('id="googleLoginBtn"');
		expect(res.text).not.toContain('id="userMenu"');
	});
});

/* ============================ /api/session ============================ */

describe("GET /api/session", () => {
	it("401 dan anonymous bila tidak login", async () => {
		setSession(null);
		const res = await request(app).get("/api/session");
		expect(res.status).toBe(401);
		expect(res.body.authenticated).toBe(false);
		expect(res.headers["cache-control"]).toBe("no-store");
	});

	it("200 dengan user bila login", async () => {
		setSession(USER);
		const res = await request(app).get("/api/session").set("Cookie", SESSION);
		expect(res.status).toBe(200);
		expect(res.body.authenticated).toBe(true);
		expect(res.body.user.email).toBe("budi@example.com");
	});
});

/* ============================ /api/logout ============================ */

describe("POST /api/logout", () => {
	it("502 bila backend tidak terjangkau", async () => {
		logoutSession.mockResolvedValue(false);
		const res = await request(app).post("/api/logout");
		expect(res.status).toBe(502);
		expect(res.body.success).toBe(false);
	});

	it("403 untuk cross-origin", async () => {
		const res = await request(app)
			.post("/api/logout")
			.set("Origin", "https://evil.test");
		expect(res.status).toBe(403);
	});

	it("200 bila backend logout berhasil", async () => {
		logoutSession.mockResolvedValue(true);
		const res = await request(app).post("/api/logout").set("Cookie", SESSION);
		expect(res.status).toBe(200);
		expect(res.body.success).toBe(true);
		expect(logoutSession).toHaveBeenCalledWith(SESSION);
	});
});

/* ====================== fallback terjemahan ====================== */

describe("fallback i18n per-key", () => {
	it("locale ja/ko/zh tidak pernah mencetak undefined", async () => {
		for (const loc of ["en", "id", "ja", "ko", "zh"]) {
			const res = await request(app).get("/").set("Cookie", `locale=${loc}`);
			expect(res.text, `locale ${loc}`).not.toContain(">undefined<");
		}
	});

	it("kunci baru ada di locale id saat login", async () => {
		setSession(USER);
		const res = await request(app)
			.get("/")
			.set("Cookie", `${SESSION}; locale=id`);
		expect(res.text).toContain("Masuk sebagai");
		expect(res.text).toContain("Selamat datang kembali");
		expect(res.text).toContain("Keluar");
	});

	it("kunci baru ada di locale en saat login", async () => {
		setSession(USER);
		const res = await request(app)
			.get("/")
			.set("Cookie", `${SESSION}; locale=en`);
		expect(res.text).toContain("Signed in as");
		expect(res.text).toContain("Welcome back");
		expect(res.text).toContain("Sign out");
	});

	it("judul modal tetap diterjemahkan di locale ja/ko/zh", async () => {
		setSession(USER);
		for (const loc of ["ja", "ko", "zh"]) {
			const res = await request(app)
				.get("/")
				.set("Cookie", `${SESSION}; locale=${loc}`);
			// ja/ko/zh belum punya terjemahan -> harus jatuh ke en, bukan kosong
			expect(res.text, `locale ${loc}`).toContain("Welcome back");
			expect(res.text, `locale ${loc}`).toContain("Signed in as");
		}
	});
});
