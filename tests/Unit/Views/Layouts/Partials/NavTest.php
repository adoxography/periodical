<?php

namespace Tests\Unit\Views\Layouts\Partials;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NavTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->withPermissions();
    }

    /** @test */
    public function it_shows_the_name_of_the_blog()
    {
        $view = $this->view('layouts.partials.nav');
        $view->assertSee(config('app.name'));
    }

    /** @test */
    public function it_shows_a_posts_link()
    {
        $view = $this->view('layouts.partials.nav');
        $view->assertSee('Posts');
    }

    /** @test */
    public function it_shows_the_compose_link_if_the_user_is_signed_in_as_a_contributor()
    {
        $user = User::factory()->withPermissionTo('create posts')->create();

        $view = $this->actingAs($user)->view('layouts.partials.nav');

        $view->assertSee('Compose');
    }

    /** @test */
    public function it_does_not_show_the_compose_link_if_the_user_is_signed_in_but_is_not_a_contributor()
    {
        $user = User::factory()->create();

        $view = $this->actingAs($user)->view('layouts.partials.nav');

        $view->assertDontSee('Compose');
    }

    /** @test */
    public function it_does_not_show_a_compose_link_if_the_user_is_a_guest()
    {
        $this->assertGuest();

        $view = $this->view('layouts.partials.nav');

        $view->assertDontSee('Compose');
    }

    /** @test */
    public function it_shows_the_contact_link_if_the_user_is_a_guest()
    {
        $this->assertGuest();

        $view = $this->view('layouts.partials.nav');

        $view->assertSee('Contact');
    }

    /** @test */
    public function it_does_not_show_a_contact_link_if_the_user_is_signed_in()
    {
        $view = $this->actingAs(User::factory()->create())->view('layouts.partials.nav');
        $view->assertDontSee('Contact');
    }

    /** @test */
    public function it_shows_the_account_link_if_the_user_is_signed_in()
    {
        $user = User::factory()->create([
            'avatar' => 'https://placekitten.com/500'
        ]);

        $view = $this->actingAs($user)->view('layouts.partials.nav');

        $view->assertSee('My account');
        $view->assertSee('https://placekitten.com/500');
    }

    /** @test */
    public function it_does_not_show_an_account_link_if_the_user_is_not_signed_in()
    {
        $this->assertGuest();

        $view = $this->view('layouts.partials.nav');

        $view->assertDontSee('My account');
    }
}
