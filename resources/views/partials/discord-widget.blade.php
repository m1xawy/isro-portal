@if (nova_get_setting('discord_widget_enable'))
    <iframe src="https://discordapp.com/widget?id={{ nova_get_setting('discord_widget_id', '') }}&theme=dark" width="100%" height="500" allowtransparency="true" frameborder="0"></iframe>
@endif
