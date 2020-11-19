<?php

namespace Tests\Unit\Models;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function it_has_an_avatar_url()
    {
        $user = new User(['avatar' => 'foo.jpg']);

        $this->assertEquals('/foo.jpg', $user->avatar_url);
    }

    /** @test */
    public function empty_avatars_are_an_empty_string()
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
