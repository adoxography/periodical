<x-app-layout>
    <section class="about">
        <header class="about__header">
            <img
                class="about__avatar"
                src="{{ $admin->avatar_url ?? 'https://placekitten.com/300' }}"
                alt="{{ $admin->name ?? 'Jane Doe' }}"
            />
            <h2 class="about__title">Hi, I'm {{ $admin->name ?? 'Jane Doe' }}</h2>
            <p class="about__subtitle">Welcome to my blog!</p>
        </header>

        <p class="about__body">
            {{ settings('description', 'Welcome to your new blog! You can change this text into a proper intro by editing your user settings.') }}
        </p>
    </section>

    <section class="post-feed-section">
        <h3 class="post-feed-section__title">
            Get started by reading some of my latest posts!
        </h3>

        <x-post-feed :posts="$posts" />

        <div class="center-content-x">
            <a class="post-feed-section__cta btn btn--dark" href="/posts">
                See all posts
            </a>
        </div>
    </section>
</x-app-layout>
