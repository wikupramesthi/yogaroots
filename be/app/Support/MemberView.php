<?php

namespace App\Support;

/**
 * Menentukan versi tampilan untuk member (role "user").
 *
 * HP selalu dapat phone-frame mobile dan tidak bisa kesasar ke desktop:
 * User-Agent mobile menang atas segalanya. Override manual (?view= /
 * session `member_view`) hanya berlaku di laptop/desktop — misal untuk
 * preview versi mobile dari laptop.
 */
class MemberView
{
    public static function isMobile(): bool
    {
        $isMobileUa = (bool) preg_match(
            '/Mobile|Android|iPhone|iPad|iPod/i',
            request()->userAgent() ?: ''
        );

        // HP: selalu mobile, tiap ganti halaman tetap mobile.
        if ($isMobileUa) {
            return true;
        }

        // Laptop/desktop: boleh override via query (?view=mobile/desktop).
        $query = request()->query('view');
        if ($query === 'mobile' || $query === 'desktop') {
            session(['member_view' => $query]);
            return $query === 'mobile';
        }

        $forced = session('member_view');

        if ($forced === 'mobile') {
            return true;
        }

        // Laptop/desktop tanpa override: view desktop.
        return false;
    }
}
