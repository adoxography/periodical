<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditPostTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Post $post;

    public function setUp(): void
    {
        parent::setUp();

        $this->withPermissions();
        $this->user = User::factory()->withPermissionTo('create posts')->create();
        $this->post = Post::factory()->create([
            'title' => 'Test Post',
            'body' => 'Lorem **ipsum** dolor sit amet, consetetur sadipscing elitr, sed diam',
            'author_id' => $this->user
        ]);
    }

    /** @test */
    public function a_post_can_be_edited_by_a_contributor()
    {
        $response = $this->actingAs($this->user)->get("/posts/{$this->post->slug}/edit");

        $response->assertOk();
        $response->assertViewIs('posts.edit');
        $response->assertViewHas('post', $this->post);
        $response->assertSee('Test Post');
        $response->assertSeeText('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam');
    }

    /** @test */
    public function a_guest_cannot_edit_a_post()
    {
        $this->assertGuest();

        $response = $this->get("/posts/{$this->post->slug}/edit");

        $response->assertRedirect('/');
    }

    /** @test */
    public function a_user_cannot_edit_another_users_post()
    {
        $otherUser = User::factory()->create();

        $response = $this->actingAs($otherUser)->get("/posts/{$this->post->slug}/edit");

        $response->assertUnauthorized();
    }
}
