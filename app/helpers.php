<?php

use App\SiteSettings;

if (!function_exists('settings')) {

    function settings(): SiteSettings
    {
        return app(SiteSettings::class);
    }
}
