<x-app-layout>
    <section class="about">
        <header class="about__header">
            <img
                class="about__avatar"
                src="{{ $admin->avatar }}"
                alt="{{ $admin->name }}"
            />
            <h2 class="about__title">Hi, I'm {{ $admin->name }}</h2>
            <p class="about__subtitle">Welcome to my blog!</p>
        </header>

        <p class="about__body">
            {{ $admin->bio }}
        </p>
    </section>

    <section class="post-feed-section">
        <h3 class="post-feed-section__title">
            Get started by reading some of my latest posts!
        </h3>

        <x-post-feed :posts="$posts" />

        <div class="center-content-x">
            <a class="post-feed-section__cta btn" href="/posts">
                See all posts
            </a>
        </div>
    </section>
</x-app-layout>
