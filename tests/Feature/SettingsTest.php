<?php

namespace Tests\Feature;

use App\SiteSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->withFakeSettings([
            'title' => 'Fake title',
            'description' => 'Fake description'
        ]);
    }

    /** @test */
    public function it_has_a_title()
    {
        $this->assertEquals('Fake title', settings()->title);
    }

    /** @test */
    public function it_has_a_description()
    {
        $this->assertEquals('Fake description', settings()->description);
    }
}
