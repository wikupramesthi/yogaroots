/** 404 untuk halaman yang tidak dikenal. */
export function notFound(req, res) {
  res.status(404).render("pages/404", { title: "Halaman Tidak Ditemukan — 404" });
}

/** Error handler terakhir: sembunyikan detail di production. */
 // eslint-disable-next-line no-unused-vars
export function errorHandler(err, req, res, next) {
  const status = err.status && Number.isInteger(err.status) ? err.status : 500;
  if (process.env.NODE_ENV !== "production") console.error("[FE ERROR]", err);
  if (res.headersSent) return next(err);

  // API internal selalu JSON
  if (req.path.startsWith("/api/")) {
    return res.status(status).json({
      success: false,
      message: status === 500 ? "Terjadi kesalahan server." : err.message,
    });
  }
  if (status === 404) return res.status(404).render("pages/404", { title: "Halaman Tidak Ditemukan — 404" });
  return res.status(status).render("pages/404", { title: "Terjadi Kesalahan — YogaRoots" });
}
