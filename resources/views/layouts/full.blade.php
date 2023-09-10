<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ nova_get_setting('server_name', config('app.name', 'Laravel')) }} - @yield('title')</title>
        <meta name="description" content="{{ nova_get_setting('server_desc', '') }}">
        <link rel="shortcut icon" href="{{ asset(Storage::url(nova_get_setting('server_favicon', ''))) }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- SEO -->
        <meta property="og:url" content="{{ nova_get_setting('server_url') }}" />
        <meta property="og:locale" content="{{ language()->getCode() }}" />
        <meta property="og:type" content="website" />
        <meta property="og:site_name" content="{{ nova_get_setting('server_name', config('app.name', 'Laravel')) }}"/>
        <meta property="og:title" content="{{ nova_get_setting('server_name', config('app.name', 'Laravel')) }} - @yield('title')" />
        <meta property="og:image" content="{{ asset(Storage::url(nova_get_setting('server_logo', ''))) }}" />
        <meta property="og:image:secure_url" content="{{ asset(Storage::url(nova_get_setting('server_logo', ''))) }}" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Custom -->
        <script type="text/javascript" src="{{ asset('js/theme-switch.js') }}"></script>

        @if(nova_get_setting('theme_mode') == 'customize')
            @include('partials.appearance-settings')
        @endif

        @yield('styles')
    </head>
    <body class="font-sans antialiased min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        @section('header')
            <header class="bg-gray-600 dark:bg-gray-800 shadow relative block w-full bg-center bg-cover bg-fixed bg-no-repeat bg-blend-multiply" style="background-image: url({{ asset(Storage::url(nova_get_setting('color_background_image', ''))) }})">
                <div class="max-w-7xl mx-auto py-14 px-4 sm:px-6 lg:px-8">
                    <h2 class="font-semibold text-xl text-white dark:text-white leading-tight mx-8">
                        @yield('title')
                    </h2>

                    @include('partials.breadcrumb')
                </div>
            </header>
        @show

        <!-- Page Content -->
        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </div>
        </main>

        @include('layouts.footer')

        @yield('scripts')
    </body>
</html>
