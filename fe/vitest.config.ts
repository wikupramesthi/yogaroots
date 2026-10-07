import { defineConfig } from "vitest/config";

export default defineConfig({
	test: {
		environment: "node",
		include: ["tests/**/*.test.ts"],
		globals: false,
		env: {
			// Dipakai src/config/env.ts yang di-import transitif.
			API_URL: "http://127.0.0.1:8000/api",
			API_KEY: "test-key",
			SITE_URL: "http://localhost:3000",
			NODE_ENV: "test",
		},
		// Backend tidak dijalankan saat test: seluruh panggilan di-mock.
		restoreMocks: true,
	},
});
