<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="//code.jquery.com/jquery-latest.js"></script>
    <script src="//cdn.jsdelivr.net/npm/featherlight@1.7.14/release/featherlight.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
    <script src="https://kit.fontawesome.com/7227a65b7d.js" crossorigin="anonymous"></script>
    @yield('head_scripts')
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Featherlight styles -->
    <link href="//cdn.jsdelivr.net/npm/featherlight@1.7.14/release/featherlight.min.css" type="text/css" rel="stylesheet" />
</head>
<body>
    @yield('body_top_scripts')
    @include('layouts.inc.nav')
    @yield('hero')
    <main>
        <div class="mt-2 container">
            @include('layouts.inc.notifications')
            @yield('content')
        </div>
    </main>
    @yield('body_bottom_scripts')
</body>
</html>
