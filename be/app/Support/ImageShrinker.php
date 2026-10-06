<?php

namespace App\Support;

/**
 * Kompresi gambar upload (GD) agar ringan dibuka di HP.
 * Gagal diam-diam: file asli tetap dipakai.
 */
class ImageShrinker
{
    public static function shrink(string $absolutePath, int $maxPx = 1024, int $quality = 82): void
    {
        try {
            $info = @getimagesize($absolutePath);
            if (! $info) {
                return;
            }

            [$w, $h] = $info;
            if ($w <= $maxPx && $h <= $maxPx) {
                return;
            }

            $mime = $info['mime'] ?? '';
            $src = match ($mime) {
                'image/jpeg' => @imagecreatefromjpeg($absolutePath),
                'image/png' => @imagecreatefrompng($absolutePath),
                'image/webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($absolutePath) : false,
                default => false,
            };
            if (! $src) {
                return;
            }

            $scale = min($maxPx / $w, $maxPx / $h);
            $nw = max(1, (int) round($w * $scale));
            $nh = max(1, (int) round($h * $scale));

            $dst = imagecreatetruecolor($nw, $nh);
            if (in_array($mime, ['image/png', 'image/webp'], true)) {
                imagealphablending($dst, false);
                imagesavealpha($dst, true);
                imagefill($dst, 0, 0, imagecolorallocatealpha($dst, 0, 0, 0, 127));
            }
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);

            match ($mime) {
                'image/jpeg' => imagejpeg($dst, $absolutePath, $quality),
                'image/png' => imagepng($dst, $absolutePath, 7),
                'image/webp' => function_exists('imagewebp') ? imagewebp($dst, $absolutePath, $quality) : false,
                default => false,
            };

            imagedestroy($src);
            imagedestroy($dst);
        } catch (\Throwable) {
            // Abaikan: file asli tetap dipakai.
        }
    }
}
