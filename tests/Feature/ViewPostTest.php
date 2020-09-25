<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewPostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_post_can_be_viewed()
    {
        $created_time = now();

        $post = Post::factory()->create([
            'title' => 'Test Post',
            'slug' => 'test-post-12345',
            'body' => 'Lorem **ipsum** dolor sit amet, consetetur sadipscing elitr, sed diam',
            'created_at' => $created_time
        ]);

        $response = $this->get($post->url);

        $response->assertOk();
        $response->assertViewIs('posts.show');
        $response->assertViewHas('post', $post);
        $response->assertSee('Test Post');
        $response->assertSeeText('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam');
        $response->assertSee($created_time);
    }

    /** @test */
    public function a_post_shows_its_image()
    {
        $post = Post::factory()->create(['image' => 'https://placekitten.com/1024']);

        $response = $this->get($post->url);

        $response->assertOk();
        $response->assertSee('https://placekitten.com/1024');
    }

    /** @test */
    public function the_author_information_is_visible()
    {
        $post = Post::factory()->forAuthor([
            'name' => 'Foo Bar',
            'avatar' => 'https://placekitten.com/500'
        ])->create();

        $response = $this->get($post->url);

        $response->assertOk();
        $response->assertSee('Foo Bar');
        $response->assertSee('https://placekitten.com/500');
    }

    /** @test */
    public function the_updated_time_appears_if_it_is_different_from_the_created_time()
    {
        $created_time = now();
        $updated_time = now()->addDays(1);

        $post = Post::factory()->create([
            'created_at' => $created_time,
            'updated_at' => $updated_time
        ]);

        $response = $this->get($post->url);

        $response->assertOk();
        $response->assertSee('Last updated');
        $response->assertSee($updated_time);
    }

    /** @test */
    public function the_updated_time_does_not_appear_if_it_is_the_same_as_the_created_time()
    {
        $time = now();

        $post = Post::factory()->create([
            'created_at' => $time,
            'updated_at' => $time
        ]);

        $response = $this->get($post->url);

        $response->assertOk();
        $response->assertDontSee('Last updated');
    }

    /** @test */
    public function the_author_can_see_post_controls()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $post = Post::factory()->create(['author_id' => $user]);

        $response = $this->actingAs($user)->get($post->url);

        $response->assertOk();
        $response->assertSee('Edit');
    }

    /** @test */
    public function a_guest_cannot_see_post_controls()
    {
        $post = Post::factory()->create();

        $response = $this->get($post->url);

        $response->assertOk();
        $response->assertDontSee('Edit');
    }

    /** @test */
    public function another_user_cannot_see_post_controls()
    {
        $post = Post::factory()->create();

        $response = $this->actingAs(User::factory()->create())->get($post->url);

        $response->assertOk();
        $response->assertDontSee('Edit');
    }

    /** @test */
    public function it_shows_a_link_to_the_most_recent_earlier_post()
    {
        $post1 = Post::factory()->create();
        $post2 = Post::factory()->create(['created_at' => now()->addHours(1)]);

        $response = $this->get($post1->url);

        $response->assertOk();
        $response->assertSee('More recent');
        $response->assertSee($post2->url);
    }

    /** @test */
    public function it_shows_no_recent_earlier_post_link_if_there_is_none()
    {
        $post = Post::factory()->create();

        $response = $this->get($post->url);

        $response->assertOk();
        $response->assertDontSee('More recent');
    }

    /** @test */
    public function it_shows_a_link_to_the_most_recent_later_post()
    {
        $post1 = Post::factory()->create();
        $post2 = Post::factory()->create(['created_at' => now()->addHours(1)]);

        $response = $this->get($post2->url);

        $response->assertOk();
        $response->assertSee('Older');
        $response->assertSee($post1->url);
    }

    /** @test */
    public function it_shows_no_recent_later_post_link_if_there_is_none()
    {
        $post = Post::factory()->create();

        $response = $this->get($post->url);

        $response->assertOk();
        $response->assertDontSee('Older');
    }

    /** @test */
    public function it_shows_the_status_if_there_is_one()
    {
        $post = Post::factory()->create();
        $this->withSession(['status' => 'Flash message']);

        $response = $this->get($post->url);

        $response->assertOk();
        $response->assertSee('Flash message');
    }

    /** @test */
    public function it_shows_its_comments()
    {
        $post = Post::factory()->hasComments(1, [
            'user_id' => User::factory()->create(['name' => 'John Doe']),
            'body' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam'
        ])->create();

        $response = $this->get($post->url);

        $response->assertOk();
        $response->assertSee('John Doe');
        $response->assertSee('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam');
    }
}
