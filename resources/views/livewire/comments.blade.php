<div class="comment-feed">
    @foreach ($post->comments as $comment)
        @include('components.comment-card', compact('comment'))
    @endforeach
</div>

<livewire:comment-form :post="$post" />
