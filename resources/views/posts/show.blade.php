<x-app-layout>
    <article class="blog-post">
        <header class="blog-post__header">
            <img
                aria-hidden="true"
                class="blog-post__splash"
                src="{{ $post->image_url }}"
            />

            @if (Auth::check() && Auth::id() === $post->author_id)
                <div class="blog-post__controls">
                    <a class="blog-post__control" href="{{ $post->url }}/edit" aria-label="Edit">
                        <svg aria-hidden xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M17.561 2.439c-1.442-1.443-2.525-1.227-2.525-1.227L8.984 7.264 2.21 14.037 1.2 18.799l4.763-1.01 6.774-6.771 6.052-6.052c-.001 0 .216-1.083-1.228-2.527zM5.68 17.217l-1.624.35a3.71 3.71 0 00-.69-.932 3.742 3.742 0 00-.932-.691l.35-1.623.47-.469s.883.018 1.881 1.016c.997.996 1.016 1.881 1.016 1.881l-.471.468z"/></svg>
                    </a>

                    <form action="{{ $post->url }}" method="POST" x-data @submit="return confirm('Are you sure?')">
                        @method('DELETE')
                        @csrf

                        <button class="blog-post__control" type="submit" aria-label="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M3.389 7.113L4.49 18.021c.061.461 2.287 1.977 5.51 1.979 3.225-.002 5.451-1.518 5.511-1.979l1.102-10.908C14.929 8.055 12.412 8.5 10 8.5c-2.41 0-4.928-.445-6.611-1.387zm9.779-5.603l-.859-.951C11.977.086 11.617 0 10.916 0H9.085c-.7 0-1.061.086-1.392.559l-.859.951C4.264 1.959 2.4 3.15 2.4 4.029v.17C2.4 5.746 5.803 7 10 7c4.198 0 7.601-1.254 7.601-2.801v-.17c0-.879-1.863-2.07-4.433-2.519zM12.07 4.34L11 3H9L7.932 4.34h-1.7s1.862-2.221 2.111-2.522c.19-.23.384-.318.636-.318h2.043c.253 0 .447.088.637.318.248.301 2.111 2.522 2.111 2.522h-1.7z"/></svg>
                        </button>
                    </form>
                </div>
            @endif

            <div class="blog-post__header-info">
                <h1 class="blog-post__title">{{ $post->title }}</h1>

                <div class="byline">
                    <a href="{{ $post->author->url }}" class="contents">
                        <img
                            class="byline__avatar"
                            src={{ $post->author->avatar_url }}
                            alt="{{ $post->author->name }}"
                        />
                    </a>

                    <address class="byline__author">
                        <a rel="author" href="{{ $post->author->url }}">{{ $post->author->name }}</a>
                    </address>

                    <time class="byline__pubdate" pubdate="pubdate" datetime="{{ $post->created_at }}">
                        Posted {{ $post->created_at->diffForHumans() }}
                    </time>
                </div>
            </div>

        </header>

        <section class="blog-post__body">
            @markdown
{{ $post->body }}
            @endmarkdown

            @if ($post->created_at->notEqualTo($post->updated_at))
                <time class="blog-post__updated-time" datetime="{{ $post->updated_at }}">
                    Last updated {{ $post->updated_at->diffForHumans() }}
                </time>
            @endif

        </section>
    </article>

    <nav class="post-navigation">
        <div class="post-navigation__left">
            @if ($post->next)
                <a class="post-navigation__link" href="{{ $post->next->url }}">
                    <svg class="post-navigation__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    More recent: {{ $post->next->title }}
                </a>
            @endif
        </div>

        <div class="post-navigation__right">
            @if ($post->previous)
                <a class="post-navigation__link" href="{{ $post->previous->url }}">
                    Older: {{ $post->previous->title }}
                    <svg class="post-navigation__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            @endif
        </div>
    </nav>

    <hr class="divider" />

    <livewire:comments :post="$post" />
</x-app-layout>
