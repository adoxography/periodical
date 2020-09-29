<ul class="post-feed">
    @foreach ($posts as $post)
        <li>
            <x-post-preview :post="$post" />
        </li>
    @endforeach
</ul>
