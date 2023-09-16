@php
    $expire = now()->addSeconds(setting('cache_setting', 600));

    $sliders = cache()->remember('slider', $expire, function() { return json_decode(setting('slider')); });
    $server_info = cache()->remember('server_info', $expire, function() { return json_decode(setting('server_info')); });
    $backlinks = cache()->remember('backlinks', $expire, function() { return json_decode(setting('backlinks')); });
    $socials = cache()->remember('socials', $expire, function() { return json_decode(setting('socials')); });

    $server_url = cache()->remember('server_url', $expire, function() { return setting('server_url', config('app.url')); });
    $server_name = cache()->remember('server_name', $expire, function() { return setting('server_name', config('app.name', 'Laravel')); });
    $server_desc = cache()->remember('server_desc', $expire, function() { return setting('server_desc', ''); });
    $server_logo = cache()->remember('server_logo', $expire, function() { return setting('server_logo', ''); });
    $server_favicon = cache()->remember('server_favicon', $expire, function() { return setting('server_favicon', ''); });

    $theme_mode = cache()->remember('theme_mode', $expire, function() { return setting('theme_mode'); });
    $server_lang = cache()->remember('server_lang', $expire, function() { return setting('server_lang'); });
    $breadcrumb_enable = cache()->remember('breadcrumb_enable', $expire, function() { return setting('breadcrumb_enable'); });
    $discord_widget_enable = cache()->remember('discord_widget_enable', $expire, function() { return setting('discord_widget_enable'); });
    $discord_widget_id = cache()->remember('discord_widget_id', $expire, function() { return setting('discord_widget_id', ''); });
    $color_background_image = cache()->remember('color_background_image', $expire, function() { return setting('color_background_image', ''); });

    $get_pages = cache()->remember('get_pages', $expire, function() { return Outl1ne\PageManager\Helpers\NPMHelpers::getPages(); });
@endphp
