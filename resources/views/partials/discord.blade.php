@if (config('global.widgets.discord.enable'))
    <div class="mb-4">
        <iframe src="https://discordapp.com/widget?id={{ config('global.widgets.discord.server_id') }}&theme=dark" width="100%" height="500" allowtransparency="true" frameborder="0"></iframe>
    </div>
@endif
