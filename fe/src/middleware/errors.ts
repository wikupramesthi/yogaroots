import type { ApiError, Request, Response, NextFunction } from "../types/index.js";

/** 404 for unknown pages. */
export function notFound(req: Request, res: Response) {
  // Halaman error jangan diindeks Google.
  res.status(404).render("pages/404", { title: "Page Not Found — 404", robots: "noindex, nofollow", heroNav: true });
}

/** Last error handler: hide details in production. */
// eslint-disable-next-line no-unused-vars
export function errorHandler(err: ApiError, req: Request, res: Response, next: NextFunction) {
  const status = err.status && Number.isInteger(err.status) ? err.status : 500;
  if (process.env.NODE_ENV !== "production") console.error("[FE ERROR]", err);
  if (res.headersSent) return next(err);

  // Internal API always JSON
  if (req.path.startsWith("/api/")) {
    return res.status(status).json({
      success: false,
      message: status === 500 ? "An internal server error occurred." : err.message,
    });
  }
  if (status === 404) return res.status(404).render("pages/404", { title: "Page Not Found — 404", robots: "noindex, nofollow", heroNav: true });
  return res.status(status).render("pages/404", { title: "Something Went Wrong — YogaRoots", robots: "noindex, nofollow", heroNav: true });
}
