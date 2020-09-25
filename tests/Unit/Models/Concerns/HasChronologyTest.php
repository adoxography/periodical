<?php

namespace Tests\Unit\Models\Concerns;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class HasChronologyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_next_post_by_chronology()
    {
        $earlierPost = Post::factory()->create([
            'title' => 'Earlier',
            'created_at' => now()
        ]);
        $laterPost = Post::factory()->create([
            'title' => 'Later',
            'created_at' => now()->addHours(1)
        ]);
        Post::factory()->create([
            'title' => 'Too late',
            'created_at' => now()->addHours(2)
        ]);

        $this->assertEquals('Later', $earlierPost->next->title);
    }

    /** @test */
    public function next_returns_null_if_there_is_no_more_recent_post()
    {
        $post = Post::factory()->create();
        $this->assertNull($post->next);
    }

    /** @test */
    public function it_has_a_previous_post_by_chronology()
    {
        Post::factory()->create([
            'created_at' => now()->addHours(-2)
        ]);
        $earlierPost = Post::factory()->create([
            'title' => 'Earlier',
            'created_at' => now()->addHours(-1)
        ]);
        $laterPost = Post::factory()->create([
            'title' => 'Later',
            'created_at' => now()
        ]);

        $this->assertEquals('Earlier', $laterPost->previous->title);
    }

    /** @test */
    public function previous_returns_null_if_there_is_no_more_recent_post()
    {
        $post = Post::factory()->create();
        $this->assertNull($post->previous);
    }

    /** @test */
    public function it_caches_next()
    {
        $post1 = Post::factory()->create();
        $post2 = Post::factory()->create(['created_at' => now()->addHours(1)]);
        $next = $post1->next;

        DB::enableQueryLog();

        $cachedNext = $post1->next;

        $this->assertCount(0, DB::getQueryLog());
        $this->assertEquals($next, $cachedNext);

        DB::disableQueryLog();
    }

    /** @test */
    public function it_caches_previous()
    {
        $post1 = Post::factory()->create();
        $post2 = Post::factory()->create(['created_at' => now()->addHours(1)]);
        $previous = $post2->previous;

        DB::enableQueryLog();

        $cachedPrevious = $post2->previous;

        $this->assertCount(0, DB::getQueryLog());
        $this->assertEquals($previous, $cachedPrevious);

        DB::disableQueryLog();
    }
}
