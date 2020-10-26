<form
    class="blog-post"
    wire:submit.prevent="save"
>
    <div class="blog-post__header">
        <img
            class="blog-post__splash"
            @if (isset($image) || $post->image)
                src="{{ isset($image) ? $image->temporaryUrl() : $post->image_url }}"
            @endif
        />

        <div class="blog-post__header-info">
            <div class="post-form__field--title">
                <input
                    class="post-form__input--title"
                    placeholder="Post title"
                    wire:model="post.title"
                />
            </div>

            <div>
                <label class="btn splash-upload {{ isset($image) || $post->image ? 'splash-upload--filled' : '' }}">
                    <input
                        type="file"
                        accept="image/*"
                        wire:model="image"
                    />
                    Change image
                </label>
            </div>
        </div>
    </div>

    <div
        wire:ignore
        x-data
        x-init="new MediumEditor($refs.mediumEditor, {
            placeholder: {
                text: 'Write something inspiring!'
            },
            extensions: {
                markdown: new MeMarkdown(md => $wire.set('post.body', md))
            }
        })"
        x-ref="mediumEditor"
        class="post-form__editor"
    >
        @markdown
{{ $post->body }}
        @endmarkdown
    </div>

    <div class="post-form__submit-container">
        <button class="btn post-form__submit" type="submit">
            Post
        </button>
    </div>
</form>
