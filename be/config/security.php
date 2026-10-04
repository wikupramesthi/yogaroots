<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Brute-force protection
    |--------------------------------------------------------------------------
    |
    | After failed login attempts exceed the threshold below within a
    | given time window, the IP address and/or email will be temporarily blocked.
    |
    */
    'brute_force' => [
        'max_attempts' => (int) env('SECURITY_MAX_LOGIN_ATTEMPTS', 3),
        'decay_minutes' => (int) env('SECURITY_LOGIN_DECAY_MINUTES', 10),
        'lockout_minutes' => (int) env('SECURITY_LOGIN_LOCKOUT_MINUTES', 5),
    ],

    /*
    |--------------------------------------------------------------------------
    | Anomaly detection
    |--------------------------------------------------------------------------
    |
    | Thresholds for flagging suspicious login activity on the
    | Login Activity and Failed Login pages.
    |
    */
    'anomaly' => [
        'window_hours' => (int) env('SECURITY_ANOMALY_WINDOW_HOURS', 24),
        'distinct_ip_threshold' => (int) env('SECURITY_ANOMALY_DISTINCT_IPS', 3),
        'failed_threshold' => (int) env('SECURITY_ANOMALY_FAILED_ATTEMPTS', 5),
        'off_hours' => [0, 5],
    ],

];
