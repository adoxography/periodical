<?php

namespace Tests\Feature;

use App\Http\Livewire\UserSettings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class UserSettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_the_user_name()
    {
        $user = User::factory()->create(['name' => 'Foo Bar']);

        $component = Livewire::test(UserSettings::class, compact('user'));

        $component->assertSee('Foo Bar');
    }

    /** @test */
    public function it_updates_the_user_name()
    {
        $user = User::factory()->create(['name' => 'Foo Bar']);
        $component = Livewire::test(UserSettings::class, compact('user'));

        $component->set('user.name', 'Jane Doe');
        $component->call('save');

        $this->assertEquals('Jane Doe', $user->fresh()->name);
    }

    /** @test */
    public function the_user_name_is_required()
    {
        $user = User::factory()->create(['name' => 'Foo Bar']);
        $component = Livewire::test(UserSettings::class, compact('user'));

        $component->set('user.name', '');
        $component->call('save');

        $component->assertHasErrors(['user.name' => 'required']);
        $this->assertEquals('Foo Bar', $user->fresh()->name);
    }

    /** @test */
    public function it_shows_the_user_email()
    {
        $user = User::factory()->create(['email' => 'foo@bar.com']);

        $component = Livewire::test(UserSettings::class, compact('user'));

        $component->assertSee('foo@bar.com');
    }

    /** @test */
    public function it_updates_the_user_email()
    {
        $user = User::factory()->create(['email' => 'Foo Bar']);
        $component = Livewire::test(UserSettings::class, compact('user'));

        $component->set('user.email', 'jane.doe@foo.com');
        $component->call('save');

        $this->assertEquals('jane.doe@foo.com', $user->fresh()->email);
    }

    /** @test */
    public function the_user_email_must_be_valid()
    {
        $user = User::factory()->create(['email' => 'Foo Bar']);
        $component = Livewire::test(UserSettings::class, compact('user'));

        $component->set('user.email', 'invalidemail');
        $component->call('save');

        $component->assertHasErrors(['user.email' => 'email']);
        $this->assertEquals('Foo Bar', $user->fresh()->email);
    }

    /** @test */
    public function the_user_email_is_required()
    {
        $user = User::factory()->create(['email' => 'Foo Bar']);
        $component = Livewire::test(UserSettings::class, compact('user'));

        $component->set('user.email', '');
        $component->call('save');

        $component->assertHasErrors(['user.email' => 'required']);
        $this->assertEquals('Foo Bar', $user->fresh()->email);
    }

    /** @test */
    public function it_shows_the_user_bio()
    {
        $user = User::factory()->create(['bio' => 'lorem ipsum dolor sit amet']);

        $component = Livewire::test(UserSettings::class, compact('user'));

        $component->assertSee('lorem ipsum dolor sit amet');
    }

    /** @test */
    public function it_updates_the_user_bio()
    {
        $user = User::factory()->create(['bio' => 'lorem dolor sit amet']);
        $component = Livewire::test(UserSettings::class, compact('user'));

        $component->set('user.bio', 'this is my new bio');
        $component->call('save');

        $this->assertEquals('this is my new bio', $user->fresh()->bio);
    }

    /** @test */
    public function it_shows_the_user_avatar()
    {
        $user = User::factory()->create(['avatar' => 'https://placekitten.com/500']);

        $component = Livewire::test(UserSettings::class, compact('user'));

        $component->assertSeeHtml('src="https://placekitten.com/500"');
    }

    /** @test */
    public function it_updates_the_user_avatar()
    {
        Storage::fake('images');
        $fakeImage = UploadedFile::fake()->image('avatar.jpg');

        $user = User::factory()->create();
        $component = Livewire::test(UserSettings::class, compact('user'))
            ->set('image', $fakeImage);

        $component->call('save');

        $this->assertNotNull($user->fresh()->avatar);
    }
}
