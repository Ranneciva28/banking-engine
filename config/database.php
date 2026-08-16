<?php

return [
    'default' => env('DB_CONNECTION', 'pgsql'),
    'connections' => [
        'pgsql' => [
            'driver' => 'pgsql',

            // Railway is currently unable to reach the Supabase direct
            // connection because that endpoint resolves to IPv6. Use the
            // Supavisor session pooler (IPv4, port 5432) instead.
            'url' => env('SUPABASE_DB_URL'),
            'host' => env('SUPABASE_DB_HOST', 'aws-0-ap-southeast-1.pooler.supabase.com'),
            'port' => env('SUPABASE_DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'postgres'),
            'username' => env('SUPABASE_DB_USERNAME', 'postgres.pnisrktkkbzspolkfkag'),
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
