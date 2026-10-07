import { existsSync, readdirSync, rmSync } from "node:fs";
import { join } from "node:path";
import { build, context } from "esbuild";

const watch = process.argv.includes("--watch");
const pagesDir = "src/browser/pages";
const pageEntries = existsSync(pagesDir)
	? readdirSync(pagesDir)
			.filter((f) => f.endsWith(".ts"))
			.map((f) => join(pagesDir, f))
	: [];

const options = {
	entryPoints: ["src/browser/main.ts", ...pageEntries],
	outbase: "src/browser",
	outdir: "public/js",
	bundle: true,
	format: "iife",
	target: "es2020",
	minify: !watch,
	sourcemap: watch ? "inline" : false,
	legalComments: "none",
	logLevel: "info",
};

if (watch) {
	const ctx = await context(options);
	await ctx.watch();
} else {
	rmSync("public/js/pages", { recursive: true, force: true });
	await build(options);
}
