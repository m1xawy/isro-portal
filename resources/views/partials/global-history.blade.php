@if (config('constants.widgets.global_history.enable'))
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Global History') }}
        </div>
        <div class="card-body">
            @php $GlobalHistory = getGlobalHistory(); @endphp
            @if (!empty($GlobalHistory))
                <ul class="list-unstyled">
                    @foreach($GlobalHistory as $value)
                        <li class="mb-3">
                            <p class="mb-0">[{{ $value->Comment }}]</p>
                            <small>
                                Sent by:
                                <a href="{{ route('ranking.character.view', ['name' => $value->CharName]) }}" class="text-decoration-none">{{ $value->CharName }}</a>
                                {{ \Carbon\Carbon::make($value->EventTime)->diffForHumans() }}
                            </small>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-center">No records found!</p>
            @endif

            <div class="d-grid mx-auto">
                <a href="{{ route('pages.global') }}" class="btn btn-primary btn-sm">{{ __('Global History') }}</a>
            </div>
        </div>
    </div>
@endif
