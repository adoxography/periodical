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
}
