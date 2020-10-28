<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->withPermissions();
    }

    /** @test */
    public function it_loads_the_correct_view()
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertViewIs('home');
    }

    /** @test */
    public function it_shows_the_four_most_recent_posts()
    {
        Post::factory()->create(['title' => 'Post #1', 'created_at' => now()]);
        Post::factory()->create(['title' => 'Post #2', 'created_at' => now()->addHours(1)]);
        Post::factory()->create(['title' => 'Post #3', 'created_at' => now()->addHours(2)]);
        Post::factory()->create(['title' => 'Post #4', 'created_at' => now()->addHours(3)]);
        Post::factory()->create(['title' => 'Post #5', 'created_at' => now()->addHours(4)]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Post #2');
        $response->assertSee('Post #3');
        $response->assertSee('Post #4');
        $response->assertSee('Post #5');
        $response->assertDontSee('Post #1');
    }

    /** @test */
    public function it_shows_the_site_description()
    {
        $this->withFakeSettings();
        settings()->put('description', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam');

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam');
    }

    /** @test */
    public function it_does_not_show_the_bio_of_anyone_who_does_not_have_permission()
    {
        $user = User::factory()->create([
            'bio' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam'
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertDontSee('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam');
    }
}
