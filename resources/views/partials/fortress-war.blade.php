@if (config('constants.widgets.fortress_war.enable'))
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Fortress War') }}
        </div>
        <div class="card-body">
            @php
                $fortresses = getFortress();
                $const = config('constants.widgets.fortress_war.data');
            @endphp
            @if (count($fortresses))
                <ul class="list-unstyled">
                    @foreach($fortresses as $value)
                        <li>
                            <span>
                                <img src="{{ $const[$value->FortressID]['icon'] }}" alt="">
                                {{ $const[$value->FortressID]['name'] }}
                            </span>
                            <span class="float-end">
                                @if($value->Name !== 'DummyGuild')
                                    <a href="{{ route('ranking.guild.view', ['name' => $value->Name]) }}" class="text-decoration-none">{{ $value->Name }}</a>
                                @else
                                    <span>None</span>
                                @endif
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-center">No records found!</p>
            @endif

            <div class="d-grid mx-auto">
                <a href="{{ route('pages.fortress') }}" class="btn btn-primary btn-sm">{{ __('Fortress History') }}</a>
            </div>
        </div>
    </div>
@endif
