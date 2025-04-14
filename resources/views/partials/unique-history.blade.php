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
                    @foreach($uniqueHistory as $value)
                        <li class="mb-3">
                            <p class="mb-0">{{ $unique_name[$value->MobID] }}</p>
                            <small>
                                Killed by:
                                <a href="{{ route('ranking.character.view', ['name' => $value->CharName16]) }}" class="text-decoration-none">{{ $value->CharName16 }}</a>
                                {{ \Carbon\Carbon::make($value->EventDate)->diffForHumans() }}
                            </small>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-center">No records found!</p>
            @endif

            <div class="d-grid mx-auto">
                <a href="{{ route('pages.uniques') }}" class="btn btn-primary btn-sm">{{ __('Unique Tracker') }}</a>
            </div>
        </div>
    </div>
@endif
