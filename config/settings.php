<?php

use Spatie\LaravelSettings\SettingsRepositories\DatabaseSettingsRepository;

return [
    'settings' => [
        App\SiteSettings::class
    ],

    'migrations_path' => database_path('settings'),

    'default_repository' => 'database',

    'repositories' => [
        'database' => [
            'type' => DatabaseSettingsRepository::class,
            'model' => null,
            'connection' => null
        ]
    ],

    'auto_discover_settings' => [
        app()->path()
    ],

    'cache_path' => storage_path('app/laravel-settings')
];
