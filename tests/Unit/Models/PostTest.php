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

    /** @test */
    public function its_image_url_is_absolute_if_it_has_a_protocol()
    {
        $post = new Post(['image' => 'https://unsplash.it/1024']);
        $this->assertEquals('https://unsplash.it/1024', $post->image_url);
    }
}
