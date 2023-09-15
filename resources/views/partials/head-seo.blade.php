<meta property="og:url" content="{{ setting('server_url', config('app.url')) }}" />
<meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}" />
<meta property="og:type" content="website" />
<meta property="og:site_name" content="{{ setting('server_name', config('app.name')) }}"/>
<meta property="og:title" content="{{ setting('server_name', config('app.name')) }} - @yield('title')" />
<meta property="og:image" content="{{ asset(Storage::url(setting('server_logo', ''))) }}" />
<meta property="og:image:secure_url" content="{{ asset(Storage::url(setting('server_logo', ''))) }}" />
