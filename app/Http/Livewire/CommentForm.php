<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\View\View;
use Livewire\Component;

class CommentForm extends Component
{
    public string $body = '';

    public Post $post;

    protected array $rules = [
        'body' => 'required|min:5'
    ];

    public function save(): void
    {
        if (!auth()->user()) {
            return;
        }

        $this->post->comments()->create(array_merge([
            'user_id' => auth()->id(),
        ], $this->validate()));

        $this->emit('commentCreated');
    }

    public function render(): View
    {
        return view('livewire.comment-form');
    }
}
