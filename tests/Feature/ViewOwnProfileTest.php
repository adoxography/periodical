<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewOwnProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_loads_the_correct_view()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/me');

        $response->assertOk();
        $response->assertViewIs('users.edit');
        $response->assertSeeLivewire('user-settings');
    }

    /** @test */
    public function it_does_not_allow_guests()
    {
        $this->assertGuest();

        $response = $this->get('/me');

        $response->assertRedirect('/');
    }

    /** @test */
    public function it_shows_site_settings_if_the_user_is_an_administrator()
    {
        $this->withPermissions();

        $user = User::factory()->create()->givePermissionTo('alter site settings');

        $response = $this->actingAs($user)->get('/me');

        $response->assertSee('Site settings');
        $response->assertSeeLivewire('site-settings');
    }

    /** @test */
    public function it_does_not_show_site_settings_if_the_user_does_not_have_permission()
    {
        $this->withPermissions();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/me');

        $response->assertDontSee('Site settings');
        $response->assertDontSeeLivewire('site-settings');
    }
}
