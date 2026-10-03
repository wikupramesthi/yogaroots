import sanitizeHtml from "sanitize-html";

/**
 * Sanitasi HTML dari CMS/backend sebelum dirender dengan <%- ... %>.
 * Mengizinkan formatting dasar, menolak <script>/<iframe>/event-handler.
 */
const ALLOWED = {
  allowedTags: [
    "p", "br", "strong", "em", "u", "s", "blockquote",
    "ul", "ol", "li", "h1", "h2", "h3", "h4",
    "a", "img", "span", "div",
  ],
  allowedAttributes: {
    a: ["href", "title", "target", "rel"],
    img: ["src", "alt", "title", "width", "height", "loading"],
    "*": ["class", "style"],
  },
  allowedSchemes: ["http", "https", "mailto"],
  // Paksa link eksternal aman
  transformTags: {
    a: (tagName, attribs) => ({
      tagName,
      attribs: { ...attribs, rel: "noopener noreferrer", target: attribs.target || "_blank" },
    }),
  },
};

export function sanitizeRichHtml(dirty) {
  if (typeof dirty !== "string" || !dirty) return "";
  return sanitizeHtml(dirty, ALLOWED);
}

/** Escape untuk disisipkan ke atribut HTML / JS string. */
export function escapeAttr(value) {
  return String(value ?? "")
    .replace(/&/g, "&amp;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#x27;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;");
}
