import { Router } from "express";
import { sendContact } from "../../services/contactService.js";
import { getClasses } from "../../services/classService.js";
import {
  validateBooking,
  validateContact,
  validateNewsletter,
} from "../utils/validate.js";

const router = Router();

// Daftar kelas (proxy rapi ke backend, bukan yogaData undefined)
router.get("/classes", async (req, res, next) => {
  try {
    const data = await getClasses({ per_page: 50 });
    res.json(data?.data || data || []);
  } catch (err) {
    next(err);
  }
});

// Booking dummy theme — log server saja, validasi ketat
router.post("/booking", (req, res) => {
  try {
    const { name, email, kelas, date } = validateBooking(req.body);
    console.log("[BOOKING]", { name, email, kelas, date, at: new Date().toISOString() });
    res.json({
      success: true,
      message: `Terima kasih ${name}! Booking kelas ${kelas} berhasil. Kami kirim konfirmasi ke ${email}.`,
    });
  } catch (err) {
    res.status(err.status || 400).json({ success: false, message: err.message });
  }
});

// Teruskan pesan kontak ke backend
router.post("/contact", async (req, res) => {
  try {
    const result = await sendContact(validateContact(req.body));
    res.status(200).json({ success: true, message: result.message || "Pesan berhasil dikirim." });
  } catch (err) {
    res.status(err.status || 500).json({
      success: false,
      message: err.status === 500 ? "Gagal mengirim pesan." : err.message || "Gagal mengirim pesan.",
      errors: err.errors || null,
    });
  }
});

// Newsletter dummy theme
router.post("/newsletter", (req, res) => {
  try {
    validateNewsletter(req.body);
    res.json({ success: true, message: "Selamat! Kamu terdaftar di newsletter kami." });
  } catch (err) {
    res.status(400).json({ success: false, message: err.message });
  }
});

export default router;
