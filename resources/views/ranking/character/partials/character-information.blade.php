<div class="table-responsive">
    <table class="table table-striped">
        <tbody>
        <tr>
            <td>Character Name:</td>
            <td>{{ $characters->CharName16 }}</td>
        </tr>
        <tr>
            <td>Jobname:</td>
            <td>{{ $characters->NickName16 }}</td>
        </tr>
        <tr>
            <td>Guild:</td>
            <td>
                @if($characters->GuildID > 0)
                    <a href="{{ route('ranking.guild.view', ['name' => $characters->GuildName]) }}" class="text-decoration-none">{{ $characters->GuildName }}</a>
                @else
                    <span>None</span>
                @endif
            </td>
        </tr>
        <tr>
            <td>Race:</td>
            <td>
                @if($characters->RefObjID > 2000)
                    <img src="{{ asset(config('global.ranking.race')[1]['icon']) }}" alt=""/>
                    <span>{{ config('global.ranking.race')[1]['name'] }}</span>
                @else
                    <img src="{{ asset(config('global.ranking.race')[0]['icon']) }}" alt=""/>
                    <span>{{ config('global.ranking.race')[0]['name'] }}</span>
                @endif
            </td>
        </tr>
        <tr>
            <td>Level:</td>
            <td>{{ $characters->CurLevel }} / 140</td>
        </tr>
        <tr>
            <td>Item Points:</td>
            <td>{{ $characters->ItemPoints }}</td>
        </tr>
        <tr>
            <td>Title:</td>
            <td style="color: #ffc345">
                @if($characters->HwanLevel > 0)
                    [{{ config('global.ranking.hwan_titles')['EU'][$characters->HwanLevel] }}]
                @endif
            </td>
        </tr>
        </tbody>
    </table>
</div>
