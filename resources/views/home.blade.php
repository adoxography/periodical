<x-app-layout>
    @if ($admin)
        <p>
            {{ $admin->bio }}
        </p>
    @endif

    @foreach ($posts as $post)
        <a href="{{ $post->url }}">
            {{ $post->title }}
        </a>
    @endforeach
</x-app-layout>
