import { env } from "../config/env.js";

type Level = "debug" | "info" | "warn" | "error";
type Meta = Record<string, unknown>;

const ORDER: Record<Level, number> = {
	debug: 10,
	info: 20,
	warn: 30,
	error: 40,
};
const MIN: Level = env.IS_PROD ? "info" : "debug";
const REDACT =
	/pass(word)?|token|secret|key|authorization|cookie|email|phone|no_telp|nama|isi/i;

function redact(meta: Meta): Meta {
	const out: Meta = {};
	for (const [k, v] of Object.entries(meta)) {
		out[k] = REDACT.test(k) ? "[redacted]" : v;
	}
	return out;
}

function write(level: Level, message: string, meta: Meta = {}) {
	if (process.env.VITEST || ORDER[level] < ORDER[MIN]) return;
	const entry = {
		time: new Date().toISOString(),
		level,
		message,
		...redact(meta),
	};
	const line = env.IS_PROD
		? JSON.stringify(entry)
		: `[${entry.time}] ${level.toUpperCase()} ${message} ${Object.keys(meta).length ? JSON.stringify(redact(meta)) : ""}`;
	(level === "error" || level === "warn" ? console.error : console.log)(line);
}

export const logger = {
	debug: (message: string, meta?: Meta) => write("debug", message, meta),
	info: (message: string, meta?: Meta) => write("info", message, meta),
	warn: (message: string, meta?: Meta) => write("warn", message, meta),
	error: (message: string, meta?: Meta) => write("error", message, meta),
};
