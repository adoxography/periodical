<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Tests\TestCase;

class SocialLoginTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->withPermissions();
    }

    public function socialProviders()
    {
        return [
            'google' => ['google', 'https://accounts.google.com/o/oauth2/auth'],
            'facebook' => ['facebook', 'https://facebook.com/v3.0/dialog/oauth']
        ];
    }

    /**
     * @test
     * @dataProvider socialProviders
     */
    public function can_redirect_to_provider_for_authentication($provider, $redirectUrl)
    {
        $providerMock = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $providerMock->shouldReceive('redirect')
                     ->andReturn(new RedirectResponse($redirectUrl));

        Socialite::shouldReceive('driver')->with($provider)->andReturn($providerMock);

        $response = $this->get("/social/auth/$provider");

        $response->assertRedirect($redirectUrl);
    }

    /**
     * @test
     * @dataProvider socialProviders
     */
    public function can_authenticate_using_a_provider($provider)
    {
        $provider_id = rand();
        $user = Mockery::mock('Laravel\Socialite\Two\User');
        $user->shouldReceive('getId')
             ->andReturn($provider_id)
             ->shouldReceive('getEmail')
             ->andReturn('john.doe@acme.com')
             ->shouldReceive('getName')
             ->andReturn('John Doe')
             ->shouldReceive('getAvatar')
             ->andReturn('https://placekitten.com/300');

        $providerMock = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $providerMock->shouldReceive('user')->andReturn($user);

        Socialite::shouldReceive('driver')->andReturn($providerMock);

        $response = $this->get("/social/auth/$provider/callback");

        $response->assertRedirect('/posts');
        $this->assertAuthenticated();

        $socialAccount = Auth::user()->accounts()->where('provider_name', $provider)->first();
        $this->assertEquals($provider_id, $socialAccount->provider_id);
    }

    /** @test */
    public function the_first_user_to_sign_up_becomes_the_administrator()
    {
        $provider_id = rand();
        $user = Mockery::mock('Laravel\Socialite\Two\User');
        $user->shouldReceive('getId')
             ->andReturn($provider_id)
             ->shouldReceive('getEmail')
             ->andReturn('john.doe@acme.com')
             ->shouldReceive('getName')
             ->andReturn('John Doe')
             ->shouldReceive('getAvatar')
             ->andReturn('https://placekitten.com/300');

        $providerMock = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $providerMock->shouldReceive('user')->andReturn($user);

        Socialite::shouldReceive('driver')->andReturn($providerMock);

        $response = $this->get("/social/auth/google/callback");

        $this->assertAuthenticated();
        $this->assertTrue(Auth::user()->hasRole('administrator'));
        $this->assertTrue(Auth::user()->hasRole('contributor'));
    }

    /** @test */
    public function subsequent_users_do_not_become_administrators()
    {
        User::factory()->create();

        $provider_id = rand();
        $user = Mockery::mock('Laravel\Socialite\Two\User');
        $user->shouldReceive('getId')
             ->andReturn($provider_id)
             ->shouldReceive('getEmail')
             ->andReturn('john.doe@acme.com')
             ->shouldReceive('getName')
             ->andReturn('John Doe')
             ->shouldReceive('getAvatar')
             ->andReturn('https://placekitten.com/300');

        $providerMock = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $providerMock->shouldReceive('user')->andReturn($user);

        Socialite::shouldReceive('driver')->andReturn($providerMock);

        $response = $this->get("/social/auth/google/callback");

        $this->assertAuthenticated();
        $this->assertFalse(Auth::user()->hasRole('administrator'));
        $this->assertFalse(Auth::user()->hasRole('contributor'));
    }

    /** @test */
    public function aborts_redirection_if_the_provider_is_not_known()
    {
        $response = $this->get('/social/auth/badprovider');
        $response->assertStatus(404);
    }

    /** @test */
    public function aborts_callback_if_the_provider_is_not_known()
    {
        $response = $this->get('/social/auth/badprovider/callback');
        $response->assertStatus(404);
    }

    /** @test */
    public function an_authenticated_user_can_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
