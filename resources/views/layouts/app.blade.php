<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('constants.general.server_name') }} - @yield('title')</title>
    <meta name="description" content="{{ config('constants.general.server_desc') }}">
    <link rel="shortcut icon" href="{{ asset(config('constants.general.favicon')) }}">

    <!-- SEO -->
    @include('partials.seo')
    <!-- Scripts -->
    {{--@vite(['resources/css/app.css', 'resources/js/app.js'])--}}

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- Inline Styles -->
    @stack('styles')
</head>

<body>
@include('layouts.header')

<main>
    @section('breadcrumb')
        @include('partials.breadcrumb')
    @show

    <div class="container">
        <div class="row">
            <div class="col-md-9">
                @yield('content')
            </div>
            <div class="col-md-3">
                @include('layouts.sidebar')
            </div>
        </div>
    </div><!-- /.container -->

    @include('layouts.footer')
</main>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script defer src="{{ asset('js/bootstrap.bundle.min.js') }}" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"></script>
<script src="https://kit.fontawesome.com/3d3e6e21dd.js" crossorigin="anonymous"></script>
<script defer src="{{ asset('js/function.js') }}"></script>

<script type="text/javascript">
    var ServerTime = new Date( {{ now()->format('Y, n, j, G, i, s') }} );
    var iTimeStamp = {{ now()->format('U') }} - Math.round( + new Date() / 1000 );
    startClockTimer('#idTimerClock');
</script>

<!-- Inline Scripts -->
@yield('scripts')

</body>
</html>
