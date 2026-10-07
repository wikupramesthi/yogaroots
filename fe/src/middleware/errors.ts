import type {
	ApiError,
	NextFunction,
	Request,
	Response,
} from "../types/index.js";
import { logger } from "../utils/logger.js";

/** Render halaman 404 standar (noindex). Dipakai route & handler error. */
export function renderNotFound(res: Response, title = "Page Not Found — 404") {
	return res
		.status(404)
		.render("pages/404", { title, robots: "noindex, nofollow", heroNav: true });
}

/** True bila error = resource tidak ada / input slug tidak valid. */
export function isNotFound(err: ApiError): boolean {
	return err.status === 404 || err.status === 400;
}

export function notFound(_req: Request, res: Response) {
	renderNotFound(res);
}

/** Error handler terakhir: detail disembunyikan dari pengunjung. */
export function errorHandler(
	err: ApiError,
	req: Request,
	res: Response,
	next: NextFunction,
) {
	const raw = err.status && Number.isInteger(err.status) ? err.status : 500;
	const fromBackend = Boolean(err.fromBackend);
	const status = fromBackend && raw !== 404 ? 502 : raw;

	logger.error("unhandled error", {
		path: req.path,
		status,
		backendStatus: fromBackend ? raw : undefined,
		message: err.message,
		stack: status >= 500 ? err.stack : undefined,
	});
	if (res.headersSent) return next(err);

	if (req.path.startsWith("/api/")) {
		return res.status(status).json({
			success: false,
			message:
				status >= 500 ? "An internal server error occurred." : err.message,
		});
	}
	if (status === 404) return renderNotFound(res);
	return res.status(status).render("pages/404", {
		title: "Something Went Wrong — YogaRoots",
		robots: "noindex, nofollow",
		heroNav: true,
	});
}
