<?php

$env = new Dotenv\Dotenv(__DIR__);
$env->load();

return [
    'paths' => [
        'migrations' => getenv('DB_APP_MIGRATION_PATH'),
        'seeds' => getenv('DB_APP_SEEDS_PATH'),
    ],
    'environments' => [
        'default_migration_table' => getenv('DB_APP_MIGRATION_TABLE'),
        'default_database' => 'dev',
        'dev' => [
            'adapter' => getenv('DB_APP_MIGRATION_ADAPTER') ?: 'mysql',
            'table_prefix' => getenv('DB_TABLE_PREFIX') ?: '',
            'table_suffix' => getenv('DB_TABLE_SUFFIX') ?: '',
            'host' => getenv('DB_APP_HOST') ?: 'localhost',
            'name' => getenv('DB_APP_NAME') ?: 'db',
            'user' => getenv('DB_APP_USER') ?: 'root',
            'pass' => getenv('DB_APP_PASS') ?: 'root',
            'port' => getenv('DB_APP_CHARSET') ?: '3306',
            'unix_socket' => getenv('DB_APP_SOCKET') ?: null,
        ],
        'prod' => [
            'adapter' => getenv('DB_APP_MIGRATION_ADAPTER') ?: 'mysql',
            'table_prefix' => getenv('DB_TABLE_PREFIX') ?: '',
            'table_suffix' => getenv('DB_TABLE_SUFFIX') ?: '',
            'host' => getenv('DB_APP_HOST') ?: 'localhost',
            'name' => getenv('DB_APP_NAME') ?: 'db',
            'user' => getenv('DB_APP_USER') ?: 'root',
            'pass' => getenv('DB_APP_PASS') ?: 'root',
            'port' => getenv('DB_APP_CHARSET') ?: '3306',
            'unix_socket' => getenv('DB_APP_SOCKET') ?: null,
        ]
    ],
];
