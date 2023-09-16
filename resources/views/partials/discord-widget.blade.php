@if (cache()->remember('discord_widget_enable', 600, function() { return setting('discord_widget_enable'); }))
    <iframe src="https://discordapp.com/widget?id={{ cache()->remember('discord_widget_id', 600, function() { return setting('discord_widget_id', ''); }) }}&theme=dark" width="100%" height="500" allowtransparency="true" frameborder="0"></iframe>
@endif
