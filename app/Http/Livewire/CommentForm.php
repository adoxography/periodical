<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class CommentForm extends Component
{
    public string $body = '';

    public Post $post;

    protected array $rules = [
        'body' => 'required'
    ];

    public function save(): void
    {
        if (!Auth::user()) {
            return;
        }

        $this->post->comments()->create(array_merge([
            'user_id' => Auth::id(),
        ], $this->validate()));

        $this->emit('commentCreated');
    }

    public function render(): View
    {
        return view('livewire.comment-form');
    }
}
