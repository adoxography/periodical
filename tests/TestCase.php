<?php

namespace Tests;

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
}
