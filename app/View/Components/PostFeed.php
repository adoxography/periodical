<?php

namespace App\View\Components;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;

class PostFeed extends Component
{
    /** @var Collection|Paginator */
    public $posts;

    /** @var Collection|Paginator $posts */
    public function __construct($posts)
    {
        $this->posts = $posts;
    }

    public function render(): View
    {
        return view('components.post-feed');
    }
}
