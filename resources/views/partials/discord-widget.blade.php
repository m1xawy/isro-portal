@php
    $discord_widget_enable = cache()->remember('discord_widget_enable', setting('cache_setting', 600), function() { return setting('discord_widget_enable'); });
    $discord_widget_id = cache()->remember('discord_widget_id', setting('cache_setting', 600), function() { return setting('discord_widget_id', ''); });
@endphp

@if ($discord_widget_enable)
    <iframe src="https://discordapp.com/widget?id={{ $discord_widget_id }}&theme=dark" width="100%" height="500" allowtransparency="true" frameborder="0"></iframe>
@endif
