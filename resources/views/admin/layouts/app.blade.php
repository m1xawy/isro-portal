<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('global.general.options.server_name') }} - @yield('title')</title>
    <meta name="description" content="{{ config('global.general.options.server_desc') }}">
    <link rel="shortcut icon" href="{{ asset(config('global.general.options.favicon')) }}">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/dashboard.css') }}" rel="stylesheet">
    <!-- Inline Styles -->
    @stack('styles')
</head>
<body data-bs-theme="{{ config('global.general.options.theme_color_mode') }}">

@include('admin.layouts.header')

<div class="container-fluid">
    <div class="row">
        <div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
            @include('admin.layouts.sidebar')
        </div>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            @yield('content')
        </main>
    </div>
</div>

<script defer src="{{ asset('js/bootstrap.bundle.min.js') }}" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"></script>
<script src="{{ asset('js/color-modes.js') }}"></script>
<script defer src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
<link href="{{ asset('dashboard/js/dashboard.js') }}" rel="stylesheet">
<!-- Inline Scripts -->
@yield('scripts')

</body>
</html>
