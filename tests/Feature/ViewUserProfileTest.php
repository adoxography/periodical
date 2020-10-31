<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewUserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->withPermissions();
    }

    /** @test */
    public function users_without_permission_do_not_have_a_bio()
    {
        $user = User::factory()->create();

        $response = $this->get($user->url);

        $response->assertStatus(404);
    }

    /** @test */
    public function it_returns_the_correct_view()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create()->givePermissionTo('have bio');

        $response = $this->get($user->url);

        $response->assertOk();
        $response->assertViewIs('users.show');
        $response->assertViewHas('user', $user);
    }

    /** @test */
    public function it_shows_the_user_name()
    {
        $user = User::factory()->create(['name' => 'Test User'])->givePermissionTo('have bio');

        $response = $this->get($user->url);

        $response->assertOk();
        $response->assertSee('Test User');
    }

    /** @test */
    public function it_shows_the_user_avatar()
    {
        $user = User::factory()->create(['avatar' => 'https://placekitten.com/500'])->givePermissionTo('have bio');

        $response = $this->get($user->url);

        $response->assertOk();
        $response->assertSee('https://placekitten.com/500');
    }

    /** @test */
    public function it_shows_the_user_bio()
    {
        $user = User::factory()->create(['bio' => 'lorem ipsum dolor sit amet'])->givePermissionTo('have bio');

        $response = $this->get($user->url);

        $response->assertOk();
        $response->assertSee('lorem ipsum dolor sit amet');
    }

    /** @test */
    public function it_shows_the_most_recent_four_posts()
    {
        $user = User::factory()->create()->givePermissionTo('have bio');

        Post::factory()->create([
            'author_id' => $user,
            'title' => 'User Post 0',
            'created_at' => now()
        ]);
        Post::factory()->create([
            'author_id' => $user,
            'title' => 'User Post 1',
            'created_at' => now()->addMinutes(1)
        ]);
        Post::factory()->create([
            'title' => 'Other Post',
            'created_at' => now()->addMinutes(2)
        ]);
        Post::factory()->create([
            'author_id' => $user,
            'title' => 'User Post 2',
            'created_at' => now()->addMinutes(3)
        ]);
        Post::factory()->create([
            'author_id' => $user,
            'title' => 'User Post 3',
            'created_at' => now()->addMinutes(4)
        ]);
        Post::factory()->create([
            'author_id' => $user,
            'title' => 'User Post 4',
            'created_at' => now()->addMinutes(5)
        ]);

        $response = $this->get($user->url);

        $response->assertOk();
        $response->assertSee('User Post 0');
        $response->assertSee('User Post 1');
        $response->assertSee('User Post 2');
        $response->assertSee('User Post 3');
        $response->assertDontSee('Other Post');
        $response->assertDontSee('User Post 4');
    }
}
