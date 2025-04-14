@if (config('constants.widgets.fortress_war.enable'))
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Fortress War') }}
        </div>
        <div class="card-body">
            @if (count($fortress_war))
                <ul class="list-unstyled">
                    @foreach($fortress_war as $value)
                        <li>
                            <span>
                                <img src="{{ config('constants.widgets.fortress_war.data')[$value->FortressID]['icon'] }}" alt="">
                                {{ config('constants.widgets.fortress_war.data')[$value->FortressID]['name'] }}
                            </span>
                            <span class="float-end">
                                @if($value->Name !== 'DummyGuild')
                                    <a href="{{ route('ranking.guild.view', ['name' => $value->Name]) }}" class="text-decoration-none">{{ $value->Name }}</a>
                                @else
                                    <span>{{ __('DummyGuild') }}</span>
                                @endif
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-center">{{ __('No Records Found!') }}</p>
            @endif

            <div class="d-grid mx-auto">
                <a href="{{ route('pages.fortress') }}" class="btn btn-primary btn-sm">{{ __('Fortress History') }}</a>
            </div>
        </div>
    </div>
@endif
