<?php

namespace Tests\Unit\Http\Livewire;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CommentFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_comment_on_a_post()
    {
        $commenter = User::factory()->create();
        $post = Post::factory()->create();
        $component = Livewire::actingAs($commenter)->test('comment-form', ['post' => $post]);

        $component->set('body', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam')
            ->call('save');

        $this->assertDatabaseHas('comments', [
            'user_id' => $commenter->id,
            'body' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam'
        ]);
    }

    /** @test */
    public function a_comment_created_event_is_emitted_when_a_comment_is_created()
    {
        $commenter = User::factory()->create();
        $post = Post::factory()->create();
        $component = Livewire::actingAs($commenter)->test('comment-form', ['post' => $post]);

        $component->set('body', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam')
            ->call('save');

        $component->assertEmitted('commentCreated');
    }

    /** @test */
    public function the_body_is_required()
    {
        $commenter = User::factory()->create();
        $post = Post::factory()->create();
        $component = Livewire::actingAs($commenter)->test('comment-form', ['post' => $post]);

        $component->set('body', '')
                  ->call('save');

        $component->assertHasErrors(['body' => 'required']);
        $this->assertDatabaseMissing('comments', ['user_id' => $commenter->id]);
    }

    /** @test */
    public function a_guest_cannot_comment()
    {
        $post = Post::factory()->create();
        $this->assertGuest();
        $component = Livewire::test('comment-form', ['post' => $post]);

        $component->set('body', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam')
            ->call('save');

        $this->assertDatabaseMissing('comments', [
            'body' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam'
        ]);
    }

    /** @test */
    public function the_user_is_prompted_to_sign_in_if_they_are_a_guest()
    {
        $post = Post::factory()->create();
        $this->assertGuest();

        $component = Livewire::test('comment-form', ['post' => $post]);

        $component->assertSee('Sign in');
    }

    /** @test */
    public function there_is_no_sign_in_prompt_if_the_user_is_authenticated()
    {
        $post = Post::factory()->create();

        $component = Livewire::actingAs(User::factory()->create())
            ->test('comment-form', ['post' => $post]);

        $component->assertDontSee('Sign in');
    }
}
