<?php

namespace Tests\Unit;

use App\Models\SocialAccount;
use App\Models\User;
use App\SocialAccountService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Two\User as SocialUser;
use Mockery;
use Tests\TestCase;

class SocialAccountServiceTest extends TestCase
{
    use RefreshDatabase;

    private SocialAccountService $accountService;
    private $social;

    public function setUp(): void
    {
        parent::setUp();

        $this->accountService = new SocialAccountService();
        $this->social = Mockery::mock(SocialUser::class);
    }

    /** @test */
    public function it_creates_new_users_and_accounts()
    {
        $provider_id = rand();
        $this->social->shouldReceive('getId')
                   ->andReturn($provider_id)
                   ->shouldReceive('getEmail')
                   ->andReturn('john.doe@example.com')
                   ->shouldReceive('getName')
                   ->andReturn('John Doe')
                   ->shouldReceive('getAvatar')
                   ->andReturn('https://placekitten.com/300');

        $user = $this->accountService->findOrCreate($this->social, 'fakeservice');

        $this->assertNotNull($user->id);
        $this->assertEquals('john.doe@example.com', $user->email);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('https://placekitten.com/300', $user->avatar);
        $this->assertContains('fakeservice', $user->accounts->pluck('provider_name'));
        $account = $user->accounts()->where('provider_name', 'fakeservice')->first();
        $this->assertEquals($provider_id, $account->provider_id);
    }

    /** @test */
    public function it_creates_new_accounts_for_existing_users()
    {
        $provider_id = rand();
        $existingUser = User::factory()->create(['email' => 'john.doe@example.com']);
        $this->social->shouldReceive('getId')
                   ->andReturn($provider_id)
                   ->shouldReceive('getEmail')
                   ->andReturn('john.doe@example.com')
                   ->shouldReceive('getName')
                   ->andReturn('')
                   ->shouldReceive('getAvatar')
                   ->andReturn('');

        $user = $this->accountService->findOrCreate($this->social, 'fakeservice');

        $this->assertEquals($existingUser->id, $user->id);
        $this->assertEquals('john.doe@example.com', $user->email);
        $this->assertContains('fakeservice', $user->accounts->pluck('provider_name'));
        $account = $user->accounts()->where('provider_name', 'fakeservice')->first();
        $this->assertEquals($provider_id, $account->provider_id);
    }

    /** @test */
    public function it_finds_existing_accounts()
    {
        $provider_id = rand();
        $existingAccount = SocialAccount::factory()->create([
            'provider_name' => 'fakeservice',
            'provider_id' => $provider_id
        ]);
        $this->social->shouldReceive('getId')->andReturn($provider_id);

        $user = $this->accountService->findOrCreate($this->social, 'fakeservice');

        $this->assertContains('fakeservice', $user->accounts->pluck('provider_name'));
        $account = $user->accounts()->where('provider_name', 'fakeservice')->first();
        $this->assertEquals($existingAccount->id, $account->id);
        $this->assertEquals($provider_id, $account->provider_id);
    }
}
