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

    /** @test */
    public function at_most_10_posts_are_shown_per_page()
    {
        Post::factory()->count(11)->create();

        $response = $this->get('/posts');

        $response->assertOk();
        $response->assertViewHas('posts');
        $this->assertCount(10, $response['posts']);
    }

    /** @test */
    public function a_next_page_button_appears_if_there_are_more_pages()
    {
        Post::factory()->count(11)->create();

        $response = $this->get('/posts');

        $response->assertOk();
        $response->assertSee('Next page');
    }

    /** @test */
    public function a_previous_page_button_appears_if_there_are_previous_pages()
    {
        Post::factory()->count(11)->create();

        $response = $this->get('/posts?page=2');

        $response->assertOk();
        $response->assertSee('Previous page');
    }

    /** @test */
    public function a_next_page_button_does_not_appear_if_there_are_no_more_pages()
    {
        Post::factory()->count(1)->create();

        $response = $this->get('/posts');

        $response->assertOk();
        $response->assertDontSee('Next page');
    }

    /** @test */
    public function a_previous_page_button_does_not_appear_if_there_are_no_previous_pages()
    {
        Post::factory()->count(1)->create();

        $response = $this->get('/posts');

        $response->assertOk();
        $response->assertDontSee('Previous page');
    }
}
