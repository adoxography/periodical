<?php

namespace Tests\Unit\Views\Layouts\Partials;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FooterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_a_login_link_if_the_user_is_a_guest()
    {
        $this->assertGuest();

        $view = $this->view('layouts.partials.footer');

        $view->assertSee('Sign in');
        $view->assertDontSee('Sign out');
    }

    /** @test */
    public function it_shows_a_logout_link_if_the_user_is_authenticated()
    {
        $this->actingAs(User::factory()->create());

        $view = $this->view('layouts.partials.footer');

        $view->assertSee('Sign out');
        $view->assertDontSee('Sign in');
    }
}
