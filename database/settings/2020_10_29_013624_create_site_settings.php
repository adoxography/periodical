<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateSiteSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.title', 'Periodical.');
        $this->migrator->add(
            'site.description',
            'Welcome to your new blog! You can change this text into a proper intro by editing your user settings.'
        );
    }
}
