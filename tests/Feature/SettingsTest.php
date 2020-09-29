<?php

namespace Tests\Feature;

use App\Settings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->withFakeSettings();
    }

    /** @test */
    public function it_retrieves_the_settings_object()
    {
        $this->assertInstanceOf(Settings::class, settings());
    }

    /** @test */
    public function it_retrieves_values()
    {
        settings()->put('foo', 'bar');

        $this->assertEquals('bar', settings('foo'));
    }

    /** @test */
    public function it_can_provide_a_default_value()
    {
        $this->assertNull(settings('foo'));

        $this->assertEquals('bar', settings('foo', 'bar'));
    }
}
