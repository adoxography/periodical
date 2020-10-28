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

        if ($this->post->exists()) {
            $this->post->update($validatedData['post']);
            session()->flash('status', 'Post edited successfully');
        } else {
            $this->post = auth()->user()->posts()->save(new Post($validatedData['post']));
            session()->flash('status', 'Post created successfully');
        }

        return redirect("/posts/{$this->post->slug}");
    }

    public function render(): View
    {
        return view('livewire.post-form');
    }
}
