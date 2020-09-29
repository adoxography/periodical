<x-app-layout>
    <x-post-feed :posts="$posts" />

    {{ $posts->links('posts.partials.pagination') }}
</x-app-layout>
