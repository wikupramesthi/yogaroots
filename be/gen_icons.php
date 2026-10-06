<?php
// Generate PWA icons from the best available source. Run: php gen_icons.php
$srcCandidates = [__DIR__ . '/public/img/fav.png', __DIR__ . '/public/img/logo-yogaroots.png'];
$src = null;
foreach ($srcCandidates as $c) {
    if (!file_exists($c)) continue;
    $info = getimagesize($c);
    if ($info && $info[0] >= 128) { $src = $c; break; }
    if (!$src) $src = $c;
}
if (!$src) { fwrite(STDERR, "no source\n"); exit(1); }

$raw = file_get_contents($src);
$in = imagecreatefromstring($raw);
[$w, $h] = [imagesx($in), imagesy($in)];
echo "source: $src {$w}x{$h}\n";

function save($im, $path) {
    imagealphablending($im, false);
    imagesavealpha($im, true);
    imagepng($im, $path, 9);
    echo "wrote $path\n";
}

// Square crop center then resize (any-purpose icons keep transparency)
$side = min($w, $h);
$crop = imagecreatetruecolor($side, $side);
imagealphablending($crop, false);
imagesavealpha($crop, true);
$transparent = imagecolorallocatealpha($crop, 0, 0, 0, 127);
imagefill($crop, 0, 0, $transparent);
imagecopy($crop, $in, 0, 0, (int)(($w - $side) / 2), (int)(($h - $side) / 2), $side, $side);

foreach ([192, 512] as $size) {
    $out = imagecreatetruecolor($size, $size);
    imagealphablending($out, false);
    imagesavealpha($out, true);
    imagefill($out, 0, 0, imagecolorallocatealpha($out, 0, 0, 0, 127));
    imagecopyresampled($out, $crop, 0, 0, 0, 0, $size, $size, $side, $side);
    save($out, __DIR__ . "/public/img/icon-{$size}.png");
    imagedestroy($out);
}

// Maskable: logo at 70% centered on theme background (#4b6b52)
$size = 512;
$mask = imagecreatetruecolor($size, $size);
$bg = imagecolorallocate($mask, 75, 107, 82);
imagefill($mask, 0, 0, $bg);
$inner = (int)($size * 0.7);
$scaled = imagecreatetruecolor($inner, $inner);
imagealphablending($scaled, false);
imagesavealpha($scaled, true);
imagefill($scaled, 0, 0, imagecolorallocatealpha($scaled, 0, 0, 0, 127));
imagecopyresampled($scaled, $crop, 0, 0, 0, 0, $inner, $inner, $side, $side);
imagealphablending($mask, true);
imagecopy($mask, $scaled, (int)(($size - $inner) / 2), (int)(($size - $inner) / 2), 0, 0, $inner, $inner);
imagepng($mask, __DIR__ . '/public/img/icon-maskable-512.png', 9);
echo "wrote public/img/icon-maskable-512.png\n";
