import { env } from "../config/env.js";
import type { SessionUser } from "../types/index.js";

/**
 * Lapisan session untuk frontend publik.
 *
 * Login terjadi di backend Laravel (Google OAuth). Cookie session-nya
 * dibuat untuk host backend, tapi cookie tidak dibatasi port — sehingga
 * browser juga mengirimkannya ke FE. FE meneruskan header Cookie itu ke
 * endpoint web backend secara server-ke-server, lalu membaca JSON-nya.
 *
 * Konsekuensinya: TIDAK ada CORS dan tidak perlu mendekripsi cookie
 * Laravel di Node (isinya terenkripsi APP_KEY).
 */

const TIMEOUT_MS = 4_000;

/** True bila request punya cookie session — dipakai untuk skip call bila anonim. */
export function hasSessionCookie(cookieHeader?: string): boolean {
	if (!cookieHeader) return false;
	return cookieHeader.includes(`${env.SESSION_COOKIE}=`);
}

/** Cookie apa pun milikFE ikut diteruskan (locale FE dll), bukan cuma session. */
function cookieHeaderOf(cookieHeader?: string): string | undefined {
	if (!cookieHeader) return undefined;
	return cookieHeader;
}

async function callBackend(
	path: string,
	cookieHeader?: string,
	init: RequestInit = {},
): Promise<Response> {
	const controller = new AbortController();
	const timer = setTimeout(() => controller.abort(), TIMEOUT_MS);
	const cookie = cookieHeaderOf(cookieHeader);

	try {
		return await fetch(`${env.API_BASE}${path}`, {
			...init,
			signal: controller.signal,
			headers: {
				Accept: "application/json",
				...(cookie ? { Cookie: cookie } : {}),
				...(init.headers as Record<string, string> | undefined),
			},
		});
	} finally {
		clearTimeout(timer);
	}
}

/**
 * User yang sedang login, atau null.
 * Backend mati / timeout tidak boleh menggagalkan render halaman —
 *FE tetap jalan dalam mode anonim.
 */
export async function getSessionUser(
	cookieHeader?: string,
): Promise<SessionUser | null> {
	if (!hasSessionCookie(cookieHeader)) return null;

	try {
		const res = await callBackend("/auth/me", cookieHeader);
		if (!res.ok) return null;
		const data = (await res.json()) as {
			authenticated?: boolean;
			user?: SessionUser | null;
		};
		return data.authenticated && data.user ? data.user : null;
	} catch {
		return null;
	}
}

/** Logout di backend. Mengembalikan true bila request benar-benar terkirim. */
export async function logoutSession(cookieHeader?: string): Promise<boolean> {
	try {
		const res = await callBackend("/auth/me/logout", cookieHeader, {
			method: "POST",
		});
		return res.ok;
	} catch {
		return false;
	}
}
