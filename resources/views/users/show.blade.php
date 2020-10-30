<x-app-layout>
    <article class="user-profile box">
        <header class="user-profile__header">
            <img class="user-profile__avatar" src="{{ $user->avatar_url }}" />
            <h2 class="user-profile__name">
                {{ $user->name }}
            </h2>
        </header>

        @if ($user->bio)
            <p class="user-profile__bio">
                {{ $user->bio }}
            </p>
        @endif
    </article>

    <x-post-feed :posts="$user->posts->take(4)" />
</x-app-layout>
