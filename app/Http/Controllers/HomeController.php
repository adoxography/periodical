<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $posts = Post::orderBy('created_at', 'DESC')->take(4)->get();
        $admin = User::permission('show bio on homepage')->first();

        return view('home', compact('posts', 'admin'));
    }
}
