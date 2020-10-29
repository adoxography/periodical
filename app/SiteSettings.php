<?php

namespace App;

use Spatie\LaravelSettings\Settings;

class SiteSettings extends Settings
{
    public string $title;

    public string $description;

    public static function group(): string
    {
        return 'site';
    }
}
