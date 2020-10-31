<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Post;
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

    public function deleteComment(int $commentId): void
    {
        $comment = $this->post->comments()->where('id', $commentId)->first();

        if ($comment->user_id !== auth()->id() && $comment->post->author_id !== auth()->id()) {
            return;
        }

        $comment->delete();
        $this->post->load('comments');
    }
}
