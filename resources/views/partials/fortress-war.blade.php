@if (config('constants.fortress_war.enable'))
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Fortress War') }}
        </div>
        <div class="card-body">
            @php $fortresses = getFortress(); @endphp
            @if (count($fortresses))
                <ul class="list-unstyled">
                    @foreach($fortresses as $fortress)
                        <li>
                            <span>
                                <img src="{{ config('constants.fortress_war.data')[$fortress->FortressID]['icon'] }}" alt="">
                                {{ config('constants.fortress_war.data')[$fortress->FortressID]['name'] }}
                            </span>
                            <span class="float-end">
                                @if($fortress->Name !== 'DummyGuild')
                                    <a href="{{ route('ranking.guild.view', ['name' => $fortress->Name]) }}" class="text-decoration-none">{{ $fortress->Name }}</a>
                                @else
                                    <span>None</span>
                                @endif
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No Fortress.</p>
            @endif

            <div class="d-grid mx-auto">
                <a href="{{ route('pages.fortress') }}" class="btn btn-primary btn-sm">{{ __('Fortress History') }}</a>
            </div>
        </div>
    </div>
@endif
