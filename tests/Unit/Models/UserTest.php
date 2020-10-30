<?php

namespace Tests\Unit\Models;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function it_qualifies_local_avatar_urls()
    {
        $user = new User(['avatar' => 'foo.jpg']);

        $this->assertEquals('/images/foo.jpg', $user->avatar_url);
    }

    /** @test */
    public function it_leaves_remote_avatar_urls_alone()
    {
        $user = new User(['avatar' => 'https://placekitten.com/500']);

        $this->assertEquals('https://placekitten.com/500', $user->avatar_url);
    }

    /** @test */
    public function it_leaves_empty_avatars_alone()
    {
        $user = new User();
        $this->assertEquals('', $user->avatar_url);
    }

    /** @test */
    public function it_has_a_url()
    {
        $user = new User(['slug' => 'test-slug']);
        $this->assertEquals('/users/test-slug', $user->url);
    }
}
