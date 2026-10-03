const fs = require("fs");
const path = require("path");
const roots = ["resources/views", "app", "routes"];
// kata khas Indonesia (case-insensitive, word boundary), minim false-positive Inggris
const words = ["yang", "dengan", "untuk", "dari", "adalah", "tidak", "bisa", "sudah", "telah", "belum", "semua", "harus", "pilih", "tambah", "simpan", "batal", "hapus", "ubah", "lihat", "cari", "kembali", "berhasil", "gagal", "pengguna", "sandi", "masuk", "keluar", "selamat", "silakan", "silahkan", "kepada", "karena", "contoh", "kosong", "perbarui", "tampilkan", "sembunyikan", "lanjutkan", "kirim", "pesan", "beranda", "dasbor", "pengaturan", "bantuan", "kelola", "riwayat", "keamanan", "masukkan", "gunakan", "duplikat", "ganda"];
const re = new RegExp("\\b(" + words.join("|") + ")\\b", "gi");
function walk(d, out = []) {
  for (const e of fs.readdirSync(d, { withFileTypes: true })) {
    const p = path.join(d, e.name);
    if (e.isDirectory()) walk(p, out);
    else if (p.endsWith(".php")) out.push(p);
  }
  return out;
}
let files = [];
for (const r of roots) files = files.concat(walk(r));
const hits = [];
for (const f of files) {
  const c = fs.readFileSync(f, "utf8");
  const m = c.match(re);
  if (m) hits.push({ f: f.replace(/\\/g, "/"), n: m.length, words: [...new Set(m.map((x) => x.toLowerCase()))].slice(0, 8).join(",") });
}
hits.sort((a, b) => b.n - a.n);
console.log("FILES:", hits.length);
for (const h of hits) console.log(h.n + "\t" + h.f + "\t[" + h.words + "]");
