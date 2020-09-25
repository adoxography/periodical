<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class Comments extends Component
{
    public Post $post;

    /** @var array */
    protected $listeners = ['commentCreated', 'deleteComment'];

    public function render(): View
    {
        return view('livewire.comments');
    }

    public function commentCreated(): void
    {
        //
    }

    public function deleteComment(int $id): void
    {
        $comment = $this->post->comments()->where('id', $id)->first();

        if ($comment->user_id !== Auth::id() && $comment->post->author_id !== Auth::id()) {
            return;
        }

        $comment->delete();
        $this->post->load('comments');
    }
}
