<nav class="nav">
    <div class="nav__left"></div>

    <div class="nav__center">
        <a href="/">
            <h1 class="nav__title">
                {{ settings('blog name', 'Periodical') }}.
            </h1>
        </a>
    </div>

    <div class="nav__right">
        <ul class="nav__links">
            <li class="nav__link-item">
                <a class="nav__link" href="/posts">
                    Posts
                </a>
            </li>

            @can('create posts')
                <li class="nav__link-item">
                    <a class="nav__link" href="/posts/create">
                        Compose
                    </a>
                </li>
            @endcan

            @guest
                <li class="nav__link-item">
                    <a class="nav__link" href="/contact">
                        Contact
                    </a>
                </li>
            @endguest

            @auth
                <li class="nav__link-item">
                    <a class="nav__link" href="/me">
                        My account
                        <img class="avatar" src="{{ Auth::user()->avatar_url }}" />
                    </a>
                </li>
            @endauth
        </ul>
    </div>
</nav>
