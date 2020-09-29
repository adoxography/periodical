<?php

namespace Tests;

use App\Settings;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\PermissionRegistrar;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function withPermissions(): void
    {
        $this->app->make(PermissionRegistrar::class)->registerPermissions();
        $this->artisan('db:seed --class=PermissionSeeder');
    }

    public function withFakeSettings(): void
    {
        $settings = Settings::make(storage_path('app/test_settings.json'));
        $settings->flush();
        $this->app->instance(Settings::class, $settings);
    }
}
