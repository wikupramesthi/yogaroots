import { Router } from "express";
import { env } from "../config/env.js";
import type { Request, Response } from "../types/index.js";

const router = Router();
const startedAt = Date.now();

/** Liveness untuk Render/load balancer: tidak memanggil backend. */
router.get("/healthz", (_req: Request, res: Response) => {
	res.set("Cache-Control", "no-store");
	res.json({
		status: "ok",
		uptime: Math.round((Date.now() - startedAt) / 1000),
	});
});

/** Readiness: cek backend terjangkau (timeout pendek, tanpa detail sensitif). */
router.get("/readyz", async (_req: Request, res: Response) => {
	res.set("Cache-Control", "no-store");
	const controller = new AbortController();
	const timer = setTimeout(() => controller.abort(), 3_000);
	try {
		const r = await fetch(`${env.API_URL}/site-stats`, {
			signal: controller.signal,
			headers: { Accept: "application/json", "X-Api-Key": env.API_KEY },
		});
		res
			.status(r.ok ? 200 : 503)
			.json({ status: r.ok ? "ok" : "degraded", backend: r.ok });
	} catch {
		res.status(503).json({ status: "degraded", backend: false });
	} finally {
		clearTimeout(timer);
	}
});

export default router;
