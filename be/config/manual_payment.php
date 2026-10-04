<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Manual bank transfer (no payment gateway)
    |--------------------------------------------------------------------------
    |
    | Members transfer manually, then upload proof (or confirm via
    | WhatsApp). Admins verify from the order detail page and
    | activate the membership.
    |
    */

    'bank_name' => env('MANUAL_BANK_NAME', ''),
    'bank_account' => env('MANUAL_BANK_ACCOUNT', ''),
    'bank_holder' => env('MANUAL_BANK_HOLDER', ''),

    'admin_whatsapp' => env('MANUAL_ADMIN_WA', '6281321221270'),

    'proof_max_kb' => (int) env('MANUAL_PROOF_MAX_KB', 3072),
    'proof_disk' => env('MANUAL_PROOF_DISK', 'local'),
    'proof_dir' => env('MANUAL_PROOF_DIR', 'proofs'),

];
