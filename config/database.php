<?php

return [
    'default' => env('DB_CONNECTION', 'pgsql'),
    'connections' => [
        'pgsql' => [
            'driver' => 'pgsql',

            // Prefer a single canonical Postgres URL in production. This
            // avoids mismatches between host/user/password variables.
            // For Railway, use the Supabase Session Pooler URL (port 5432).
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', 'aws-0-ap-southeast-1.pooler.supabase.com'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'postgres'),
            'username' => env('DB_USERNAME', 'postgres.pnisrktkkbzspolkfkag'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public,laravel',
            'sslmode' => env('DB_SSLMODE', 'require'),
        ],
    ],
    'migrations' => [
        'table' => 'laravel.migrations',
        'update_date_on_publish' => true,
    ],
];
