@if (config('constants.widgets.global_history.enable'))
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Global History') }}
        </div>
        <div class="card-body">
            @php $GlobalHistory = getGlobalHistory(); @endphp
            @if (!empty($GlobalHistory))
                <ul class="list-unstyled">
                    @foreach($GlobalHistory as $History)
                        <li class="mb-3">
                            <p class="mb-0">[{{ $History->Comment }}]</p>
                            <small>
                                Sent by:
                                <a href="{{ route('ranking.character.view', ['name' => $History->CharName]) }}" class="text-decoration-none">{{ $History->CharName }}</a>
                                {{ \Carbon\Carbon::make($History->EventTime)->diffForHumans() }}
                            </small>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No Records.</p>
            @endif

            <div class="d-grid mx-auto">
                <a href="{{ route('pages.global') }}" class="btn btn-primary btn-sm">{{ __('Global History') }}</a>
            </div>
        </div>
    </div>
@endif
