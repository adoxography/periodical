<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewPostsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function posts_can_be_viewed()
    {
        Post::factory()->create(['title' => 'Post 1']);
        Post::factory()->create(['title' => 'Post 2']);

        $response = $this->get('/posts');

        $response->assertOk();
        $response->assertViewIs('posts.index');
        $response->assertSee('Post 1');
        $response->assertSee('Post 2');
    }

    /** @test */
    public function posts_are_ordered_by_created_at_date()
    {
        Post::factory()->create([
            'title' => 'Post 2',
            'created_at' => now()
        ]);
        Post::factory()->create([
            'title' => 'Post 1',
            'created_at' => now()->addDays(1)
        ]);

        $response = $this->get('/posts');

        $response->assertOk();
        $response->assertSeeInOrder(['Post 1', 'Post 2']);
    }
}
