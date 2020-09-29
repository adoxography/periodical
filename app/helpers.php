<?php

use App\Settings;

if (!function_exists('settings')) {
    /**
     * @param mixed $default
     */
    function settings(?string $key = null, $default = null)
    {
        if ($key === null) {
            return app(Settings::class);
        }

        return app(Settings::class)->get($key, $default);
    }
}
