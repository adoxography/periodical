<a href="{{ $post->url }}">
    <article class="post-preview-card">
        <img
            class="post-preview-card__image"
            src="{{ $post->image_url }}"
        />

        <h1
            class="post-preview-card__title"
            href="{{ $post->url }}"
        >
            {{ $post->title }}
        </h1>

        <address class="post-preview-card__byline">
            Posted
            <time pubdate="pubdate" datetime="{{ $post->created_at }}">
                {{ $post->created_at->diffForHumans() }}
            </time>
            by
            <strong>
                {{ $post->author->name }}
            </strong>
        </address>
    </article>
</a>
