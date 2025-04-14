@if (config('constants.widgets.top_guild.enable'))
<div class="card mb-4">
    <div class="card-header">
        {{ __('Top Guild') }}
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Item Points</th>
                </tr>
                </thead>
                <tbody>
                @php $topGuild = getTopGuild(); @endphp
                @php $i = 1; @endphp
                @forelse($topGuild->take(5) as $guild)
                    <tr>
                        <td>
                            @if($i <= 3)<img src="{{ config('constants.ranking.top_icons')[$i] }}" alt=""/>@else{{ $i }}@endif
                        </td>
                        <td>
                            <a href="{{ route('ranking.guild.view', ['name' => $guild->Name]) }}">{{ $guild->Name }}</a>
                        </td>
                        <td>{{ $guild->ItemPoints }}</td>
                    </tr>
                    @php $i++ @endphp
                @empty
                    <tr><td colspan="6">No Ranking available</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
