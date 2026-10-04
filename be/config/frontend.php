<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Frontend URL
    |--------------------------------------------------------------------------
    |
    | Base URL of the public website (the Express app living in /fe). The
    | backend only serves the admin panel, so canonical URLs for public
    | content (articles, pages, events, ...) must point to this host.
    |
    */

    'url' => rtrim(env('FRONTEND_URL', env('APP_URL', 'http://localhost')), '/'),
];