<div class="table-responsive">
    <table class="table table-striped">
        <tbody>
        <tr>
            <td>{{ __('Character Name:') }}</td>
            <td>{{ $characters->CharName16 }}</td>
        </tr>
        <tr>
            <td>{{ __('Jobname:') }}</td>
            <td>{{ $characters->NickName16 }}</td>
        </tr>
        <tr>
            <td>{{ __('Guild:') }}</td>
            <td>
                @if($characters->GuildID > 0)
                    <a href="{{ route('ranking.guild.view', ['name' => $characters->GuildName]) }}" class="text-decoration-none">{{ $characters->GuildName }}</a>
                @else
                    <span>{{ __('None') }}</span>
                @endif
            </td>
        </tr>
        <tr>
            <td>{{ __('Race:') }}</td>
            <td>
                @if($characters->RefObjID > 2000)
                    <img src="{{ asset(config('global.ranking.race')[1]['icon']) }}" width="16" height="16" alt=""/>
                    <span>{{ config('global.ranking.race')[1]['name'] }}</span>
                @else
                    <img src="{{ asset(config('global.ranking.race')[0]['icon']) }}" width="16" height="16" alt=""/>
                    <span>{{ config('global.ranking.race')[0]['name'] }}</span>
                @endif
            </td>
        </tr>
        <tr>
            <td>{{ __('Level:') }}</td>
            <td>{{ $characters->CurLevel }} / {{ config('global.general.options.max_level') }}</td>
        </tr>
        <tr>
            <td>{{ __('Item Points:') }}</td>
            <td>{{ $characters->ItemPoints }}</td>
        </tr>
        <tr>
            <td>{{ __('Title:') }}</td>
            <td style="color: #ffc345">
                @if($characters->HwanLevel > 0)
                    @if($characters->RefObjID > 2000)
                        [{{ config('global.ranking.hwan_titles')['EU'][$characters->HwanLevel] }}]
                    @else
                        [{{ config('global.ranking.hwan_titles')['CH'][$characters->HwanLevel] }}]
                    @endif
                @endif
            </td>
        </tr>
        </tbody>
    </table>
</div>
