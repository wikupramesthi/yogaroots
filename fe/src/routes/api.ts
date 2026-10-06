import { Router } from "express";
import { sendContact } from "../services/contactService.js";
import { getClasses } from "../services/classService.js";
import { getClassSchedules } from "../services/classScheduleService.js";
import { env } from "../config/env.js";
import {
  validateBooking,
  validateContact,
  validateNewsletter,
} from "../utils/validate.js";
import type { Request, Response, NextFunction } from "../types/index.js";

const router = Router();

// Class list (clean proxy to backend, not undefined yogaData)
router.get("/classes", async (req: Request, res: Response, next: NextFunction) => {
  try {
    const data = await getClasses({ per_page: 50 });
    res.json(data?.data || data || []);
  } catch (err) {
    next(err);
  }
});

// Class schedules (clean proxy: forwards date/level/time/studio filters)
router.get("/class-schedules", async (req: Request, res: Response, next: NextFunction) => {
  try {
    const params: Record<string, any> = {};
    if (req.query.date) params.date = req.query.date;
    if (req.query.level) params.level = req.query.level;
    if (req.query.time) params.time = req.query.time;
    if (req.query.studio_uuid) params.studio_uuid = req.query.studio_uuid;
    const perPage =
      typeof req.query.per_page === "string"
        ? parseInt(req.query.per_page, 10) || 50
        : 50;
    params.per_page = Math.min(perPage, 50);
    const data = await getClassSchedules(params);
    res.json(Array.isArray(data) ? data : data?.data || []);
  } catch (err) {
    next(err);
  }
});

// Dummy theme booking — no PII in logs, strict validation
router.post("/booking", (req: Request, res: Response) => {
  try {
    const { name, email, kelas, date } = validateBooking(req.body);
    if (!env.IS_PROD) console.debug("[BOOKING]", { kelas, date, at: new Date().toISOString() });
    res.json({
      success: true,
      message: `Thank you ${name}! Your booking for ${kelas} was successful. We've sent a confirmation to ${email}.`,
    });
  } catch (err) {
    res.status(err.status || 400).json({ success: false, message: err.message });
  }
});

// Forward contact messages to backend
router.post("/contact", async (req: Request, res: Response) => {
  try {
    const result = await sendContact(validateContact(req.body));
    res.status(200).json({ success: true, message: result.message || "Message sent successfully." });
  } catch (err) {
    res.status(err.status || 500).json({
      success: false,
      message: err.status === 500 ? "Failed to send message." : err.message || "Failed to send message.",
      errors: err.errors || null,
    });
  }
});

// Dummy theme newsletter
router.post("/newsletter", (req: Request, res: Response) => {
  try {
    validateNewsletter(req.body);
    res.json({ success: true, message: "You're subscribed to our newsletter!" });
  } catch (err) {
    res.status(400).json({ success: false, message: err.message });
  }
});

export default router;
