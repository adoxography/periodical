<?php

namespace App\View\Components;

use Illuminate\Pagination\Paginator;
use Illuminate\View\Component;
use Illuminate\View\View;

class PostFeed extends Component
{
    public Paginator $posts;

    public function __construct(Paginator $posts)
    {
        $this->posts = $posts;
    }

    public function render(): View
    {
        return view('components.post-feed');
    }
}
