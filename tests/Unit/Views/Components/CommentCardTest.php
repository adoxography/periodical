<?php

namespace Tests\Unit\Views\Components;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentCardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_close_button_appears_if_the_user_wrote_the_comment()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user]);

        $component = $this->actingAs($user)->view('components.comment-card', compact('comment'));

        $component->assertSee('Close');
    }

    /** @test */
    public function a_close_button_does_not_appear_if_the_user_did_not_write_the_comment()
    {
        $comment = Comment::factory()->create();

        $component = $this->actingAs(User::factory()->create())
                          ->view('components.comment-card', compact('comment'));

        $component->assertDontSee('Close');
    }

    /** @test */
    public function a_close_button_appears_if_the_user_wrote_the_post()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->forPost(['author_id' => $user])->create();

        $component = $this->actingAs($user)->view('components.comment-card', compact('comment'));

        $component->assertSee('Close');
    }
}
