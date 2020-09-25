<?php

namespace Tests\Unit\Http\Livewire;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class PostFormTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $fakeImage;

    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('images');

        $this->user = User::factory()->create();
        $this->fakeImage = UploadedFile::fake()->image('splash.jpg');
    }

    /** @test */
    public function an_empty_post_is_used_if_no_post_is_provided()
    {
        $component = Livewire::actingAs($this->user)
            ->test('post-form');
        $component->assertSet('post', new Post());
    }

    /** @test */
    public function the_post_title_is_wired_to_the_model()
    {
        $component = Livewire::actingAs($this->user)
            ->test('post-form');

        $component->set('post.title', 'Foo');

        $this->assertEquals('Foo', $component->post->title);
    }

    /** @test */
    public function the_post_title_is_required()
    {
        $component = Livewire::actingAs($this->user)
            ->test('post-form')
            ->set('post.body', 'Foo')
            ->set('image', $this->fakeImage);

        $component->call('save');

        $component->assertHasErrors(['post.title' => 'required']);
    }

    /** @test */
    public function the_post_body_is_wired_to_the_model()
    {
        $component = Livewire::actingAs($this->user)
            ->test('post-form');

        $component->set('post.body', '*Foo*');

        $this->assertEquals('*Foo*', $component->post->body);
    }

    /** @test */
    public function the_post_body_is_required()
    {
        $component = Livewire::actingAs($this->user)
            ->test('post-form')
            ->set('post.title', 'Foo')
            ->set('image', $this->fakeImage);

        $component->call('save');

        $component->assertHasErrors(['post.body' => 'required']);
    }

    /**
     * @test
     */
    public function the_splash_image_must_be_an_image()
    {
        $component = Livewire::actingAs($this->user)
            ->test('post-form')
            ->set('post.title', 'Foo')
            ->set('post.body', 'Bar');

        $this->expectException(\ErrorException::class);

        $component->set('image', 'x');
    }

    /** @test */
    public function it_creates_a_post()
    {
        $user = User::factory()->create();
        $component = Livewire::actingAs($user)
            ->test('post-form')
            ->set('post.title', 'Test post')
            ->set('post.body', 'Hello\n-----')
            ->set('image', $this->fakeImage);

        $component->call('save');

        $this->assertDatabaseHas('posts', [
            'title' => 'Test post',
            'body' => 'Hello\n-----',
            'author_id' => $user->id,
        ]);
    }

    /** @test */
    public function it_uploads_an_image_while_saving_if_there_is_an_image()
    {
        $user = User::factory()->create();
        $component = Livewire::actingAs($user)
            ->test('post-form')
            ->set('post.title', 'Test post')
            ->set('post.body', 'x')
            ->set('image', $this->fakeImage);

        $component->call('save');

        $post = Post::where('title', 'Test post')->first();
        Storage::disk('images')->assertExists($post->image);
    }

    /** @test */
    public function it_does_not_upload_an_image_if_there_is_none()
    {
        $post = Post::factory()->create([
            'author_id' => $this->user->id,
            'image' => 'splash.jpg'
        ]);

        $component = Livewire::actingAs($this->user)
            ->test('post-form', ['post' => $post]);

        $component->call('save');

        $this->assertEquals('splash.jpg', $post->fresh()->image);
        $this->assertCount(0, Storage::disk('images')->files());
    }

    /** @test */
    public function it_updates_a_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'author_id' => $user,
            'title' => 'This is an old post',
            'body' => '**Hello!**'
        ]);
        $component = Livewire::actingAs($user)
            ->test('post-form', ['post' => $post])
            ->set('post.title', 'This is an updated post')
            ->set('image', $this->fakeImage);

        $component->call('save');

        $this->assertDatabaseMissing('posts', ['title' => 'This is an old post']);
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'author_id' => $user->id,
            'title' => 'This is an updated post',
            'body' => '**Hello!**'
        ]);
    }

    /** @test */
    public function it_redirects_to_the_created_post()
    {
        $component = Livewire::actingAs($this->user)
            ->test('post-form')
            ->set('post.title', 'Foo')
            ->set('post.body', 'Bar')
            ->set('image', $this->fakeImage);

        $component->call('save');

        $post = Post::where('title', 'Foo')->firstOrFail();
        $component->assertRedirect("/posts/{$post->slug}");
        $component->assertSessionHas('status', 'Post created successfully');
    }

    /** @test */
    public function it_redirects_to_an_updated_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'author_id' => $user,
            'title' => 'This is an old post',
            'body' => '**Hello!**'
        ]);
        $component = Livewire::actingAs($user)
            ->test('post-form', ['post' => $post])
            ->set('post.title', 'This is an updated post')
            ->set('image', $this->fakeImage);

        $component->call('save');

        $component->assertRedirect($post->fresh()->url);
        $component->assertSessionHas('status', 'Post edited successfully');
    }
}
