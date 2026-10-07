import { Router } from "express";
import { env } from "../config/env.js";
import { getClassSchedules } from "../services/classScheduleService.js";
import { getClasses } from "../services/classService.js";
import { getContactCaptcha, sendContact } from "../services/contactService.js";
import type { NextFunction, Request, Response } from "../types/index.js";
import { toApiError } from "../utils/errors.js";
import {
	cleanDate,
	cleanText,
	UUID_RE,
	validateBooking,
	validateContact,
	validateNewsletter,
} from "../utils/validate.js";

const router = Router();

// Class list (clean proxy to backend, not undefined yogaData)
router.get(
	"/classes",
	async (_req: Request, res: Response, next: NextFunction) => {
		try {
			const data = await getClasses({ per_page: 50 });
			res.json(data?.data || data || []);
		} catch (err) {
			next(err);
		}
	},
);

// Class schedules (clean proxy: forwards date/level/time/studio filters)
router.get(
	"/class-schedules",
	async (req: Request, res: Response, next: NextFunction) => {
		try {
			const str = (v: unknown): string => (typeof v === "string" ? v : "");
			const params: Record<string, string | number> = {};
			const date = cleanDate(str(req.query.date));
			if (date) params.date = date;
			const level = cleanText(str(req.query.level), {
				max: 30,
				label: "level",
			});
			if (level) params.level = level;
			const time = cleanText(str(req.query.time), { max: 30, label: "time" });
			if (time) params.time = time;
			const studio = str(req.query.studio_uuid).trim();
			if (UUID_RE.test(studio)) params.studio_uuid = studio;
			const perPage = Number.parseInt(str(req.query.per_page), 10) || 50;
			params.per_page = Math.min(Math.max(perPage, 1), 50);
			const data = await getClassSchedules(params);
			res.json(Array.isArray(data) ? data : data?.data || []);
		} catch (err) {
			next(err);
		}
	},
);

// Dummy theme booking — no PII in logs, strict validation
router.post("/booking", (req: Request, res: Response) => {
	try {
		const { name, email, kelas, date } = validateBooking(req.body);
		if (!env.IS_PROD)
			console.debug("[BOOKING]", { kelas, date, at: new Date().toISOString() });
		res.json({
			success: true,
			message: `Thank you ${name}! Your booking for ${kelas} was successful. We've sent a confirmation to ${email}.`,
		});
	} catch (e) {
		const err = toApiError(e);
		const status = Number(err.status) || 400;
		res.status(status).json({
			success: false,
			message: status < 500 ? err.message : "Booking failed.",
		});
	}
});

router.get("/contact/captcha", async (_req: Request, res: Response) => {
	try {
		const captcha = await getContactCaptcha();
		res.set("Cache-Control", "no-store");
		res.json({
			success: true,
			captcha_id: String(captcha?.captcha_id ?? ""),
			question: String(captcha?.question ?? ""),
		});
	} catch {
		res.status(503).json({
			success: false,
			message: "Verification unavailable, please reload the page.",
		});
	}
});

// Forward contact messages to backend
router.post("/contact", async (req: Request, res: Response) => {
	try {
		const result = await sendContact(validateContact(req.body));
		res.status(200).json({
			success: true,
			message: result.message || "Message sent successfully.",
		});
	} catch (e) {
		const err = toApiError(e);
		const status = Number(err.status) || 500;
		const isClientError = status >= 400 && status < 500;
		res.status(status).json({
			success: false,
			message: isClientError
				? err.message || "Failed to send message."
				: "Failed to send message.",
			errors: isClientError ? err.errors || null : null,
		});
	}
});

// Dummy theme newsletter
router.post("/newsletter", (req: Request, res: Response) => {
	try {
		validateNewsletter(req.body);
		res.json({
			success: true,
			message: "You're subscribed to our newsletter!",
		});
	} catch (e) {
		res.status(400).json({ success: false, message: toApiError(e).message });
	}
});

export default router;
