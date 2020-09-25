<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_comments_of_a_post()
    {
        $post = Post::factory()->hasComments(1, [
            'user_id' => User::factory()->create(['name' => 'Foo Bar']),
            'body' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam'
        ])->create();

        $component = Livewire::test('comments', ['post' => $post]);

        $component->assertSee('Foo Bar');
        $component->assertSee('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam');
    }

    /** @test */
    public function it_updates_comments_when_a_comment_is_created()
    {
        $post = Post::factory()->create();
        $component = Livewire::test('comments', ['post' => $post]);
        $component->assertDontSee('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam');

        Comment::factory()->create([
            'post_id' => $post,
            'body' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam'
        ]);
        $component->emit('commentCreated');

        $component->assertSee('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam');
    }

    /** @test */
    public function a_comment_can_be_deleted_by_the_user_who_made_it()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::factory()->create([
            'post_id' => $post,
            'user_id' => $user->id,
            'body' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam'
        ]);
        $component = Livewire::actingAs($user)->test('comments', ['post' => $post]);
        $component->assertSee('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam');

        $component->emit('deleteComment', $comment->id);

        $component->assertDontSee('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam');
    }

    /** @test */
    public function a_comment_cannot_be_deleted_by_another_user()
    {
        $post = Post::factory()->create();
        $comment = Comment::factory()->create([
            'post_id' => $post,
            'body' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam'
        ]);
        $component = Livewire::actingAs(User::factory()->create())
            ->test('comments', ['post' => $post]);
        $component->assertSee('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam');

        $component->emit('deleteComment', $comment->id);

        $component->assertSee('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam');
    }

    /** @test */
    public function a_comment_can_be_deleted_by_another_user_if_they_wrote_the_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['author_id' => $user]);
        $comment = Comment::factory()->create([
            'post_id' => $post,
            'body' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam'
        ]);
        $component = Livewire::actingAs($user)->test('comments', ['post' => $post]);
        $component->assertSee('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam');

        $component->emit('deleteComment', $comment->id);

        $component->assertDontSee('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam');
    }
}
