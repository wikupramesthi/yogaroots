import type { NextFunction, Request, Response } from "../types/index.js";
import { logger } from "../utils/logger.js";

const SKIP = /^\/(css|js|img|fonts|favicon|healthz)/;

/** Log ringkas per request (method, path, status, durasi) — tanpa query/body/PII. */
export function requestLogger(req: Request, res: Response, next: NextFunction) {
	if (SKIP.test(req.path)) return next();
	const start = process.hrtime.bigint();
	res.on("finish", () => {
		const ms = Number(process.hrtime.bigint() - start) / 1e6;
		const meta = {
			method: req.method,
			path: req.path,
			status: res.statusCode,
			ms: Math.round(ms),
		};
		if (res.statusCode >= 500) logger.error("request", meta);
		else if (res.statusCode >= 400) logger.warn("request", meta);
		else logger.info("request", meta);
	});
	next();
}
