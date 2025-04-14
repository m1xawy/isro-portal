@if (config('constants.top_player.enable'))
<div class="card mb-4">
    <div class="card-header">
        {{ __('Top Players') }}
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
                @php $topPlayer = getTopPlayer(); @endphp
                @php $i = 1; @endphp
                @forelse($topPlayer->take(5) as $player)
                    <tr>
                        <td>
                            @if($i <= 3)<img src="{{ config('constants.top_icons')[$i] }}" alt=""/>@else{{ $i }}@endif
                        </td>
                        <td>
                            <a href="{{ route('ranking.character.view', ['name' => $player->CharName16]) }}">{{ $player->CharName16 }}</a>
                        </td>
                        <td>{{ $player->ItemPoints }}</td>
                    </tr>
                    @php $i++ @endphp
                @empty
                    <tr><td colspan="7">No Ranking available</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
