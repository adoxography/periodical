<?php

namespace Tests\Unit\Models;

use App\Models\Post;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    /** @test */
    public function it_has_a_url()
    {
        $post = new Post(['slug' => 'foo-bar']);
        $this->assertEquals('/posts/foo-bar', $post->url);
    }

    /** @test */
    public function it_has_an_image_url()
    {
        $post = new Post(['image' => 'foo.jpg']);
        $this->assertEquals('/foo.jpg', $post->image_url);
    }
}
