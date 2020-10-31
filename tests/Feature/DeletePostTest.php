<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeletePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_delete_their_own_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'title' => 'Test Post',
            'author_id' => $user
        ]);

        $response = $this->actingAs($user)->delete($post->url);

        $response->assertRedirect('/');
        $this->assertDeleted('posts', ['title' => 'Test Post']);
    }

    /** @test */
    public function a_guest_cannot_delete_a_post()
    {
        $post = Post::factory()->create(['title' => 'Test Post']);

        $response = $this->delete($post->url);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('posts', ['title' => 'Test Post']);
    }

    /** @test */
    public function a_user_cannot_delete_another_users_post_without_permission()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['title' => 'Test Post']);

        $response = $this->actingAs($user)->delete($post->url);

        $response->assertForbidden();
        $this->assertDatabaseHas('posts', ['title' => 'Test Post']);
    }

    /** @test */
    public function a_user_can_delete_another_users_post_if_they_have_permission()
    {
        $this->withPermissions();
        $user = User::factory()->create()->givePermissionTo("delete another user's post");
        $post = Post::factory()->create(['title' => 'Test Post']);

        $response = $this->actingAs($user)->delete($post->url);

        $response->assertRedirect('/');
        $this->assertDeleted('posts', ['title' => 'Test Post']);
    }
}
