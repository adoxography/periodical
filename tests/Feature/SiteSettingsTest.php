<?php

namespace Tests\Feature;

use App\Http\Livewire\SiteSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class SiteSettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_the_site_title()
    {
        $this->withFakeSettings(['title' => 'Fooius Barius']);

        $component = Livewire::test(SiteSettings::class);

        $component->assertSet('title', 'Fooius Barius');
    }

    /** @test */
    public function it_can_update_the_site_title()
    {
        $component = Livewire::test(SiteSettings::class);

        $component->set('title', 'My Awesome Site');
        $component->call('save');

        $this->assertEquals('My Awesome Site', settings()->title);
    }

    /** @test */
    public function it_shows_the_site_description()
    {
        $this->withFakeSettings(['description' => 'Lorem ipsum dolor sit amet']);

        $component = Livewire::test(SiteSettings::class);

        $component->assertSet('description', 'Lorem ipsum dolor sit amet');
    }

    /** @test */
    public function it_can_update_the_site_description()
    {
        $component = Livewire::test(SiteSettings::class);

        $component->set('description', 'Read all about it');
        $component->call('save');

        $this->assertEquals('Read all about it', settings()->description);
    }

    /** @test */
    public function it_flashes_a_message_when_the_settings_are_updated()
    {
        $component = Livewire::test(SiteSettings::class);

        $component->call('save');

        $component->assertDispatchedBrowserEvent('site-settings-updated');
    }
}
