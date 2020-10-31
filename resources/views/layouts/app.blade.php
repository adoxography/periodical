<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="turbolinks-cache-control" content="no-cache" />

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet" data-turbolinks-track="true">

        <!-- normalize -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" data-turbolinks-track="true" />

        @livewireStyles

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.6.0/dist/alpine.js" defer data-turbolinks-track="true"></script>
        <script src="{{ asset('js/app.js') }}" data-turbolinks-track="true"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/0.7.8/pace.min.js" integrity="sha512-t3TewtT7K7yfZo5EbAuiM01BMqlU2+JFbKirm0qCZMhywEbHZWWcPiOq+srWn8PdJ+afwX9am5iqnHmfV9+ITA==" crossorigin="anonymous" data-turbolinks-track="true"></script>

        <!-- Markdown -->
        <script src="//cdn.jsdelivr.net/npm/medium-editor@latest/dist/js/medium-editor.min.js" data-turbolinks-track="true"></script>
        <script src="https://cdn.jsdelivr.net/npm/medium-editor-markdown@3.2.2/dist/me-markdown.standalone.js" data-turbolinks-track="true"></script>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/medium-editor@latest/dist/css/medium-editor.min.css" type="text/css" media="screen" charset="utf-8" data-turbolinks-track="true">

        <!-- Styles -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap" data-turbolinks-track="true" />
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" data-turbolinks-track="true">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" data-turbolinks-track="true">
    </head>
    <body>
        <div class="body-container">
            @include('layouts.partials.nav')

            {{-- @livewire('navigation-dropdown') --}}

            @if ($errors->any())
                @foreach ($errors->all() as $message)
                    <p>{{ $message }}</p>
                @endforeach
            @endif

            @if (session()->has('status'))
                <div class="flash">
                    <p class="flash__message">
                        {{ session('status') }}
                    </p>
                </div>
            @endif

            <!-- Page Content -->
            <main id="main-content">
                {{ $slot }}
            </main>

            @include('layouts.partials.footer')
        </div>

        @stack('modals')

        @livewireScripts

        <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js" data-turbolinks-eval="false"></script>
    </body>
</html>
