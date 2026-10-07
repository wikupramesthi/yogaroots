/**
 * Tipe bersama YogaRoots FE.
 *
 * Semua bentuk data yang dipakai lintas middleware / routes / services
 * didefinisikan di sini. Untuk objek Express, gunakan re-export di bawah
 * agar tidak ada file bisnis yang import dari "express" langsung.
 */
import type { NextFunction, Request, Response } from "express";

export type { NextFunction, Request, Response };

/** Locales yang didukung theme (lihat src/middleware/i18n.ts). */
export type Locale = "en" | "id" | "ja" | "ko" | "zh";

/** Error dengan status HTTP + detail validasi (dilempar apiClient / validate). */
export interface ApiError extends Error {
	status?: number;
	errors?: Record<string, string[]>;
	fromBackend?: boolean;
}

/** Opsi request ke backend Laravel (subset RequestInit yang dipakai theme). */
export interface ApiRequestOptions {
	method?: string;
	headers?: Record<string, string>;
	body?: string;
}

/**
 * Payload mentah dari backend Laravel.
 *
 * Boundary sengaja longgar: tiap endpoint membungkus data dengan bentuk
 * berbeda (envelope `{ data }`, array, atau objek langsung), jadi
 * normalisasi dilakukan di service — bukan di boundary ini.
 */
export type BackendPayload = any;

/** Opsi cleanText() (src/utils/validate.ts). */
export interface CleanTextOptions {
	max?: number;
	label?: string;
}

/** Identitas website — bentuk normalisasi siap pakai views (`site.*`). */
export interface SiteIdentity {
	name: string;
	title: string;
	tagline: string;
	description: string;
	phone: string;
	phoneTel: string;
	email: string;
	address: string;
	instagramHandle: string;
	instagramHref: string;
	facebookHref: string;
	youtubeHref: string;
	tiktokHref: string;
	metaTitle: string;
	metaDescription: string;
	metaKeywords: string;
	gaId: string;
	siteVerification: string;
	logoUrl: string;
	logoWhiteUrl: string;
	faviconUrl: string;
	ogImage: string;
	year: number;
}

/** Artikel blog — bentuk siap pakai views. */
export interface Article {
	id: string;
	slug: string;
	title: string;
	content: string;
	image: string;
	category: string;
	date: string;
	read: string;
	excerpt: string;
}

/** Statistik agregat publik (tanpa PII). */
export interface SiteStats {
	members: number | null;
	instructors: number | null;
	classes: number | null;
}

/** Kelas yoga dari backend. */
export interface YogaClass {
	slug?: string;
	name?: string;
	description?: string;
	level?: string;
	image?: string;
	instructor?: { name?: string; avatar?: string };
}

/** Instruktur yoga. */
export interface Instructor {
	uuid?: string;
	slug?: string;
	name?: string;
	avatar?: string;
	pengalaman?: string;
	biografi?: string;
	specializations?: { name: string }[];
}

/** Event / workshop. */
export interface EventItem {
	slug?: string;
	gambar?: string;
	judul?: string;
	tanggal?: string;
	waktu_mulai?: string;
	waktu_selesai?: string;
	lokasi?: string;
	kapasitas?: string | number;
	deskripsi?: string;
}

/** Opsi harga paket membership. */
export interface PackageOption {
	name?: string;
	quota?: string | number;
	duration?: string;
	duration_unit?: string;
	price?: number | string;
	discount_price?: number | string;
	final_price?: number | string;
}

/** Fitur yang termasuk dalam paket membership. */
export interface PackageFeature {
	name?: string;
	[key: string]: unknown;
}

/** Paket membership. */
export interface PackageItem {
	slug?: string;
	name?: string;
	description?: string;
	is_popular?: boolean | number | string;
	options?: PackageOption[];
	features?: PackageFeature[];
}

/** Pertanyaan yang sering ditanyakan. */
export interface FaqItem {
	question: string;
	answer: string;
}

/** Banner / gambar galeri dari backend. */
export interface BannerItem {
	gambar: string;
	nama?: string;
}

/** Halaman CMS (konten statis yang dikelola via backend). */
export interface CmsPage {
	slug?: string;
	title: string;
	excerpt?: string;
	content: string;
	published_at?: string;
	featured_image?: string;
}

/** Captcha matematika untuk form kontak. */
export interface ContactCaptcha {
	question?: string;
	captcha_id?: string | number;
}

/** Payload form kontak setelah validasi (src/utils/validate.ts). */
export interface ContactPayload {
	nama: string;
	email: string;
	no_telp: string;
	isi: string;
	captcha_id: string;
	captcha_answer: number;
}

/** Payload booking dummy setelah validasi. */
export interface BookingPayload {
	name: string;
	email: string;
	kelas: string;
	date: string;
}
