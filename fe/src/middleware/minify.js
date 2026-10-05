import { minify } from "html-minifier-terser";
import { env } from "../config/env.js";

/**
 * Minify HTML sebelum dikirim ke browser — view-source jadi ringkas
 * (whitespace + komentar hilang), file EJS tetap rapi dan readable.
 *
 * Aman untuk theme ini:
 * - Hanya menyentuh body string yang mengandung "<html" (halaman EJS).
 *   JSON /api/* lewat res.json (content-type application/json) dilewati.
 * - conservativeCollapse: spasi antar inline-element dipertahankan.
 * - Isi <script>/<textarea> tidak diutak-atik (minifyJS off).
 * - Gagal minify → kirim HTML asli (fail-open).
 *
 * Matikan saat butuh view-source readable: HTML_MINIFY=0
 */
const OPTIONS = {
  collapseWhitespace: true,
  conservativeCollapse: true,
  removeComments: true,
  removeRedundantAttributes: true,
  removeScriptTypeAttributes: true,
  removeStyleLinkTypeAttributes: true,
  useShortDoctype: true,
  minifyCSS: true,
  minifyJS: false,
  keepClosingSlash: true,
};

export function minifyHtml() {
  return (req, res, next) => {
    if (env.HTML_MINIFY === "0") return next();
    const originalSend = res.send.bind(res);
    res.send = (body) => {
      const type = res.getHeader("content-type");
      const isJson = typeof type === "string" && type.includes("application/json");
      if (typeof body === "string" && !isJson && body.includes("<html")) {
        return minify(body, OPTIONS).then(
          (out) => originalSend(out),
          () => originalSend(body),
        );
      }
      return originalSend(body);
    };
    next();
  };
}
