@if (config('constants.widgets.unique_history.enable'))
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Unique History') }}
        </div>
        <div class="card-body">
            @php
                $uniqueHistory = getUniqueHistory();
                $unique_name = getUniqueHistoryNames();
            @endphp

            @if (!empty($uniqueHistory))
                <ul class="list-unstyled">
                    @foreach($uniqueHistory as $History)
                        <li class="mb-3">
                            <p class="mb-0">{{ $unique_name[$History->MobID] }}</p>
                            <small>
                                Killed by:
                                <a href="{{ route('ranking.character.view', ['name' => $History->CharName16]) }}" class="text-decoration-none">{{ $History->CharName16 }}</a>
                                {{ \Carbon\Carbon::make($History->EventDate)->diffForHumans() }}
                            </small>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No Records.</p>
            @endif

            <div class="d-grid mx-auto">
                <a href="{{ route('pages.uniques') }}" class="btn btn-primary btn-sm">{{ __('Unique Tracker') }}</a>
            </div>
        </div>
    </div>
@endif
