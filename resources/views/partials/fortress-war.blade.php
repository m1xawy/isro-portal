@if (config('global.widgets.fortress_war.enable'))
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Fortress War') }}
        </div>
        <div class="card-body">
            <ul class="list-unstyled">
                @forelse($fortress_war as $value)
                    <li>
                        <span>
                            <img src="{{ config('global.widgets.fortress_war.data')[$value->FortressID]['icon'] }}" alt="">
                            {{ config('global.widgets.fortress_war.data')[$value->FortressID]['name'] }}
                        </span>
                        <span class="float-end">
                            @if($value->Name !== 'DummyGuild')
                                <a href="{{ route('ranking.guild.view', ['name' => $value->Name]) }}" class="text-decoration-none">{{ $value->Name }}</a>
                            @else
                                <span>{{ __('None') }}</span>
                            @endif
                        </span>
                    </li>
                @empty
                    <p class="text-center">{{ __('No Records Found!') }}</p>
                @endforelse
            </ul>
        </div>
    </div>
@endif
