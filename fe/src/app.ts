import path from "node:path";
import { fileURLToPath } from "node:url";
import compression from "compression";
import express from "express";
import { errorHandler, notFound } from "./middleware/errors.js";
import { i18n } from "./middleware/i18n.js";
import { appLocals } from "./middleware/locals.js";
import { requestLogger } from "./middleware/logger.js";
import { minifyHtml } from "./middleware/minify.js";
import {
	cspNonce,
	sameOriginOnly,
	securityHeaders,
	writeLimiter,
} from "./middleware/security.js";
import apiRoutes from "./routes/api.js";
import healthRoutes from "./routes/health.js";
import pageRoutes from "./routes/pages.js";
import sitemapRoutes from "./routes/sitemap.js";

const ROOT = path.resolve(path.dirname(fileURLToPath(import.meta.url)), "..");

export function createApp() {
	const app = express();
	app.disable("x-powered-by");
	app.set("trust proxy", false);

	app.set("view engine", "ejs");
	app.set("views", path.join(ROOT, "views"));

	app.use(requestLogger);
	app.use("/", healthRoutes);

	app.use(cspNonce);
	app.use(securityHeaders());
	app.use(compression());
	app.use(
		express.static(path.join(ROOT, "public"), {
			maxAge: "7d",
			setHeaders: (res, filePath) => {
				if (/\.(css|js)$/i.test(filePath)) {
					res.setHeader("Cache-Control", "public, max-age=31536000, immutable");
				}
			},
		}),
	);
	app.use(express.urlencoded({ extended: true, limit: "100kb" }));
	app.use(express.json({ limit: "100kb" }));

	app.use(appLocals);
	app.use(i18n);
	app.use(minifyHtml());

	app.use("/", sitemapRoutes);
	app.use("/", pageRoutes);
	app.use("/api", writeLimiter(), sameOriginOnly, apiRoutes);

	app.use(notFound);
	app.use(errorHandler);

	return app;
}
