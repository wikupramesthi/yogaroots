import { describe, expect, it } from "vitest";
import {
	cleanDate,
	cleanEmail,
	cleanPage,
	cleanSlug,
	cleanSlugLoose,
	cleanText,
	UUID_RE,
	validateBooking,
	validateContact,
	validateNewsletter,
} from "../src/utils/validate.js";

const statusOf = (fn: () => unknown) => {
	try {
		fn();
		return 200;
	} catch (err) {
		return (err as { status?: number }).status;
	}
};

describe("cleanSlug (ketat, melempar)", () => {
	it("menerima slug huruf-kecil + strip", () => {
		expect(cleanSlug("hatha-yoga")).toBe("hatha-yoga");
		expect(cleanSlug("  vinyasa-flow ")).toBe("vinyasa-flow");
		expect(cleanSlug("a")).toBe("a");
	});

	it("menormalkan huruf besar ke kecil", () => {
		expect(cleanSlug("HATHA")).toBe("hatha");
	});

	it("menolak underscore, strip ganda, dan karakter aneh", () => {
		expect(statusOf(() => cleanSlug("a_b"))).toBe(400);
		expect(statusOf(() => cleanSlug("a--b"))).toBe(400);
		expect(statusOf(() => cleanSlug("../../etc/passwd"))).toBe(400);
		expect(statusOf(() => cleanSlug(""))).toBe(400);
	});

	it("memotong Beyond 120 karakter", () => {
		const long = `${"a".repeat(200)}-end`;
		const out = cleanSlug(long);
		expect(out.length).toBe(120);
	});
});

describe("cleanSlugLoose (longgar, tidak pernah melempar)", () => {
	it("menerima huruf besar dan underscore (sitemap)", () => {
		expect(cleanSlugLoose("Hatha_Yoga")).toBe("Hatha_Yoga");
		expect(cleanSlugLoose("terms-conditions")).toBe("terms-conditions");
	});

	it("mengembalikan string kosong, bukan throw, untuk input nakal", () => {
		expect(cleanSlugLoose("../secret")).toBe("");
		expect(cleanSlugLoose("a b")).toBe("");
		expect(cleanSlugLoose(null)).toBe("");
		expect(cleanSlugLoose(undefined)).toBe("");
		expect(cleanSlugLoose("")).toBe("");
	});

	it("tidak melempar untuk input apa pun", () => {
		for (const v of ["a/b", "<script>", "'; DROP--", 0, {}, []]) {
			expect(() => cleanSlugLoose(v)).not.toThrow();
		}
	});
});

describe("cleanText", () => {
	it("memangkas sesuai max", () => {
		expect(cleanText("a".repeat(500), { max: 10 })).toHaveLength(10);
	});

	it("memangkas, bukan menolak, saat melebihi max", () => {
		// Perilaku yang disengaja: slice lalu validasi, bukan error.
		expect(statusOf(() => cleanText("a".repeat(500), { max: 10 }))).toBe(200);
	});

	it("menolak karakter sudut (< >) untuk mencegah injeksi markup", () => {
		expect(statusOf(() => cleanText("<script>alert(1)</script>"))).toBe(400);
		expect(statusOf(() => cleanText("a > b"))).toBe(400);
	});

	it("membersihkan spasi berlebih", () => {
		expect(cleanText("  halo   dunia  ")).toBe("halo   dunia");
	});
});

describe("cleanEmail", () => {
	it("menerima email valid dan menormalkan", () => {
		expect(cleanEmail("  Foo@Bar.COM ")).toBe("foo@bar.com");
	});

	it("menolak email rusak", () => {
		for (const bad of ["foo", "foo@", "@bar.com", "a b@c.com", ""]) {
			expect(statusOf(() => cleanEmail(bad))).toBe(400);
		}
	});
});

describe("cleanPage", () => {
	it("menjadi 1 untuk input tak valid", () => {
		expect(cleanPage(undefined)).toBe(1);
		expect(cleanPage("abc")).toBe(1);
		expect(cleanPage("0")).toBe(1);
		expect(cleanPage("-3")).toBe(1);
	});

	it("mempertahankan angka positif", () => {
		expect(cleanPage("4")).toBe(4);
	});

	it("membatasi halaman maksimal 1000", () => {
		expect(cleanPage("99999")).toBe(1000);
	});
});

describe("cleanDate", () => {
	it("menerima format YYYY-MM-DD", () => {
		expect(cleanDate("2026-10-07")).toBe("2026-10-07");
	});

	it("menolak format lain", () => {
		expect(statusOf(() => cleanDate("07/10/2026"))).toBe(400);
		expect(statusOf(() => cleanDate("not-a-date"))).toBe(400);
	});
});

describe("UUID_RE", () => {
	it("mengenali UUID v4 lowercase dan uppercase", () => {
		expect(UUID_RE.test("cf4e35eb-36da-4de1-b0d9-4f36d3a618d8")).toBe(true);
		expect(UUID_RE.test("CF4E35EB-36DA-4DE1-B0D9-4F36D3A618D8")).toBe(true);
	});

	it("menolak string non-UUID", () => {
		expect(UUID_RE.test("dummy")).toBe(false);
		expect(UUID_RE.test("")).toBe(false);
	});
});

describe("validateBooking", () => {
	it("butuh name, email, kelas", () => {
		expect(statusOf(() => validateBooking({}))).toBe(400);
	});

	it("menerwati payload lengkap", () => {
		const out = validateBooking({
			name: "Budi",
			email: "budi@example.com",
			kelas: "Hatha",
			date: "2026-10-07",
		});
		expect(out).toEqual({
			name: "Budi",
			email: "budi@example.com",
			kelas: "Hatha",
			date: "2026-10-07",
		});
	});
});

describe("validateContact", () => {
	const valid = {
		nama: "Budi",
		email: "budi@example.com",
		no_telp: "081234567890",
		isi: "Halo",
		captcha_id: "cf4e35eb-36da-4de1-b0d9-4f36d3a618d8",
		captcha_answer: "17",
	};

	it("menerima payload valid", () => {
		const out = validateContact(valid);
		expect(out.nama).toBe("Budi");
		// string dari FormData harus di-coerce jadi integer
		expect(out.captcha_answer).toBe(17);
	});

	it("menolak nomor telepon rusak", () => {
		expect(statusOf(() => validateContact({ ...valid, no_telp: "abc" }))).toBe(
			400,
		);
	});

	it("menolak captcha_id yang bukan UUID", () => {
		expect(
			statusOf(() => validateContact({ ...valid, captcha_id: "dummy" })),
		).toBe(400);
	});

	it("menolak jawaban captcha di luar 0..100", () => {
		expect(
			statusOf(() => validateContact({ ...valid, captcha_answer: "101" })),
		).toBe(400);
		expect(
			statusOf(() => validateContact({ ...valid, captcha_answer: "-1" })),
		).toBe(400);
	});

	it("butuh nama dan isi", () => {
		expect(statusOf(() => validateContact({ ...valid, isi: "" }))).toBe(400);
		expect(statusOf(() => validateContact({ ...valid, nama: "" }))).toBe(400);
	});
});

describe("validateNewsletter", () => {
	it("hanya butuh email valid", () => {
		expect(validateNewsletter({ email: "a@b.co" })).toEqual({
			email: "a@b.co",
		});
		expect(statusOf(() => validateNewsletter({ email: "nope" }))).toBe(400);
	});
});
