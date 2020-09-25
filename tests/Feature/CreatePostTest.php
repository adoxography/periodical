<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreatePostTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withPermissions();
    }

    /** @test */
    public function a_contributor_can_view_the_posts_creation_page()
    {
        $user = User::factory()->withPermissionTo('create posts')->create();

        $response = $this->actingAs($user)->get('/posts/create');

        $response->assertOk();
        $response->assertViewIs('posts.create');
    }

    /** @test */
    public function a_regular_authenticated_user_cannot_view_the_posts_creation_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/posts/create');

        $response->assertForbidden();
    }

    /** @test */
    public function a_guest_cannot_view_the_posts_creation_page()
    {
        $this->assertGuest();

        $response = $this->get('/posts/create');

        $response->assertRedirect('/');
    }
}
