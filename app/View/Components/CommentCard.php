<?php

namespace App\View\Components;

use App\Models\Comment;
use Illuminate\View\Component;

class CommentCard extends Component
{
    public Comment $comment;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.comment-card');
    }
}
