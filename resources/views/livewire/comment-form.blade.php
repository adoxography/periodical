<form wire:submit.prevent="save" class="comment-form">
    <textarea
        class="comment-form__body"
        wire:model="body"
        placeholder="Leave a comment&hellip;"
        @guest
            disabled
        @endguest
    ></textarea>
    @guest
        <button
            class="btn btn--dark"
            type="button"
            x-data
            @click.prevent="$dispatch('prompt-login')"
        >
            Sign in to comment
        </button>
    @else
        <button class="btn btn--dark" disabled="{{ strlen($this->body) < 5 }}" type="submit">Comment</button>
    @endguest
</form>
