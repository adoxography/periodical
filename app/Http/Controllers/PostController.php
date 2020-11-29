<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
        $this->middleware('can:create posts')->only('create');
    }

    public function index(): View
    {
        $posts = Post::orderBy('created_at', 'DESC')
            ->with('author')
            ->simplePaginate(10);
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post): View
    {
        return view('posts.show', compact('post'));
    }

    public function create(): View
    {
        return view('posts.create');
    }

    public function edit(Post $post): View
    {
        if (auth()->id() !== $post->author_id) {
            abort(401);
        }

        return view('posts.edit', compact('post'));
    }

    public function destroy(Post $post): RedirectResponse
    {
        $user = auth()->user();

        if ($post->author_id !== $user->id && !$user->can("delete another user's post")) {
            abort(403);
        }

        $post->delete();

        return redirect('/');
    }
}
