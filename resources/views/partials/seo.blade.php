<meta property="og:url" content="{{ config('settings.general.options.server_url') }}" />
<meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}" />
<meta property="og:type" content="website" />
<meta property="og:site_name" content="{{ config('settings.general.options.server_name') }}"/>
<meta property="og:title" content="{{ config('settings.general.options.server_name') }} - @yield('title')" />
<meta property="og:image" content="{{ asset(config('settings.general.options.logo')) }}" />
<meta property="og:image:secure_url" content="{{ asset(config('settings.general.options.logo')) }}" />
