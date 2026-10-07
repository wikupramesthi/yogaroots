/**
 * YogaRoots FE — bootstrap. Susunan aplikasi ada di src/app.ts:
 *
 *   src/app.ts                 createApp(): middleware + routes
 *   src/config/env.ts          env tervalidasi (API_URL, API_KEY, SITE_URL, ...)
 *   src/middleware/            security (CSP nonce, rate limit), i18n, locals, logger, minify, errors
 *   src/routes/                pages, api (/api/*), sitemap, health (/healthz)
 *   src/services/              klien API backend + cache + normalisasi data
 *   src/browser/               TypeScript sisi browser (dibundel esbuild ke public/js)
 *   views/                     template EJS (pages/ + partials/)
 */

import { createApp } from "./src/app.js";
import { env } from "./src/config/env.js";
import { logger } from "./src/utils/logger.js";

createApp().listen(env.PORT, () => {
	logger.info(`YogaRoots FE running at http://localhost:${env.PORT}`, {
		api: env.API_URL,
	});
});
