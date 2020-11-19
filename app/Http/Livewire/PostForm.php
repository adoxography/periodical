<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostForm extends Component
{
    use WithFileUploads;

    public Post $post;

    /** @var UploadedFile */
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

    /**
     * @return RedirectResponse
     */
    public function save()
    {
        $validatedData = $this->validate();

        $postData = $validatedData['post'];

        if (isset($validatedData['image'])) {
            $postData['image'] = $validatedData['image']->store('/images');
        }

        if ($this->post->id) {
            $this->post->update($postData);
            session()->flash('status', 'Post edited successfully');
        } else {
            $this->post = Post::create(array_merge($postData, ['author_id' => Auth::id()]));
            session()->flash('status', 'Post created successfully');
        }

        return redirect("/posts/{$this->post->slug}");
    }

    public function render(): View
    {
        return view('livewire.post-form');
    }
}
