<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Redirector;
use Livewire\WithFileUploads;

class PostForm extends Component
{
    use WithFileUploads;

    public Post $post;
    public $image;

    public function mount(Post $post = null): void
    {
        $this->post = $post ?? new Post();
    }

    protected array $rules = [
        'post.title' => 'required',
        'post.body' => 'required',
        'image' => 'nullable|image'
    ];

    public function save(): Redirector
    {
        $validatedData = $this->validate();

        $postData = $validatedData['post'];

        if (isset($validatedData['image'])) {
            $postData['image'] = $validatedData['image']->store('/', $disk = 'images');
        }

        $post = auth()->user()->posts()->save($validatedData['post']);

        if ($post->wasRecentlyCreated) {
            session()->flash('status', 'Post created successfully');
        } else {
            session()->flash('status', 'Post edited successfully');
        }

        return redirect("/posts/{$post->slug}");
    }

    public function render(): View
    {
        return view('livewire.post-form');
    }
}
