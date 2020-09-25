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
            class="btn"
            type="button"
            x-data
            @click.prevent="$dispatch('prompt-login')"
        >
            Sign in to comment
        </button>
    @else
        <button class="btn" type="submit">Comment</button>
    @endguest
</form>
