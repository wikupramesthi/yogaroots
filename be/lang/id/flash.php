<?php

return [
    // Booking
    'schedule_unavailable' => 'Jadwal kelas ini tidak tersedia.',
    'need_membership' => 'Kamu butuh membership aktif dengan kuota tersisa untuk memesan kelas.',
    'already_booked_date' => 'Kamu sudah memesan kelas ini untuk tanggal tersebut.',
    'overlap_booking' => 'Kamu sudah punya booking di jam tersebut. Pilih jadwal lain.',
    'only_runs_on' => 'Kelas ini hanya ada di hari :day.',
    'booked_ok' => 'Kelas berhasil dipesan.',
    'booked_waiting' => 'Kelas penuh. Kamu masuk daftar antre.',
    'booked_in' => 'Berhasil pesan dan check-in.',
    'booked_in_remain' => 'Berhasil pesan dan check-in. Sisa kuota: :count.',
    'already_checked_in' => 'Booking ini sudah check-in.',
    'only_confirmed_checkin' => 'Hanya booking terkonfirmasi yang bisa check-in.',
    'checkin_day_only' => 'Check-in hanya bisa di hari kelas.',
    'no_quota_checkin' => 'Tidak ada membership aktif dengan kuota tersisa. Check-in ditolak.',
    'checkin_stale' => 'Booking ini tidak bisa check-in lagi.',
    'checked_in_ok' => 'Check-in berhasil.',
    'checked_in_remain' => 'Check-in berhasil. Sisa kuota: :count.',
    'cannot_cancel' => 'Booking ini tidak bisa dibatalkan.',
    'cancel_cutoff' => 'Booking hanya bisa dibatalkan minimal 2 jam sebelum kelas mulai.',
    'cancel_ok' => 'Booking dibatalkan.',
    'rate_ok' => 'Terima kasih atas penilaianmu.',
    'member_no_quota' => ':name tidak punya membership aktif dengan kuota tersisa.',
    'member_already_in' => ':name sudah check-in.',
    'member_checked_in' => ':name berhasil check-in.',
    'member_checked_in_remain' => ':name berhasil check-in. Sisa kuota: :count.',

    // Order
    'order_approve_ok' => 'Order ditandai lunas. Membership diaktifkan.',
    'order_only_pending_approve' => 'Hanya order menunggu yang bisa disetujui.',
    'order_no_option' => 'Order ini tidak punya opsi paket untuk diaktifkan.',
    'order_only_pending_reject' => 'Hanya order menunggu yang bisa ditolak.',
    'order_rejected' => 'Order ditolak.',
    'proof_pending_only' => 'Bukti hanya bisa diupload untuk order menunggu.',
    'proof_ok' => 'Bukti transfer terupload. Tunggu verifikasi admin.',
    'option_unavailable' => 'Opsi paket yang dipilih tidak tersedia.',
    'package_unavailable' => 'Paket yang dipilih tidak tersedia.',
    'package_unavailable_now' => 'Paket ini sudah tidak tersedia.',
    'active_package_block' => 'Kamu masih punya paket aktif. Kamu hanya bisa membeli paket yang sama sampai berakhir.',
    'member_active_package_block' => 'Member ini masih punya paket aktif yang berbeda.',
    'order_created' => 'Order berhasil dibuat.',
    'order_pending_exists' => 'Kamu sudah punya order menunggu untuk opsi ini. Selesaikan pembayaran.',
    'reorder_created' => 'Order baru dibuat. Selesaikan pembayaran.',
    'reorder_only_failed' => 'Hanya order gagal atau kedaluarsa yang bisa dipesan lagi.',
    'reorder_impossible' => 'Order ini tidak bisa dipesan lagi.',
    'order_owner_missing' => 'Pemilik order tidak ditemukan.',

    // Akun & profil
    'user_not_found' => 'User tidak ditemukan.',
    'profile_ok' => 'Profil berhasil diperbarui.',
    'sumber_ok' => 'Terima kasih! Nomor WhatsApp dan sumber informasimu berhasil disimpan.',

    // Notifikasi
    'notif_read_all' => 'Semua notifikasi ditandai dibaca.',
];
