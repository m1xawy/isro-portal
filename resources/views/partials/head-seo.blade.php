<meta property="og:url" content="{{ $server_url }}" />
<meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}" />
<meta property="og:type" content="website" />
<meta property="og:site_name" content="{{ $server_name }}"/>
<meta property="og:title" content="{{ $server_name }} - @yield('title')" />
<meta property="og:image" content="{{ asset(Storage::url($server_logo)) }}" />
<meta property="og:image:secure_url" content="{{ asset(Storage::url($server_logo)) }}" />
