@if (config('settings.widgets.globals_history.enable'))
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Global History') }}
        </div>
        <div class="card-body">
            <ul class="list-unstyled">
                @forelse($globals_history as $value)
                    <li class="mb-3">
                        <p class="mb-0">[{{ $value->Comment }}]</p>
                        <small>
                            {{ __('Sent by:') }}
                            @if(!empty($value->CharName))
                            <a href="{{ route('ranking.character.view', ['name' => $value->CharName]) }}" class="text-decoration-none">{{ $value->CharName }}</a>
                            @else
                                <span>{{ __('NoName') }}</span>
                            @endif
                            {{ \Carbon\Carbon::make($value->EventTime)->diffForHumans() }}
                        </small>
                    </li>
                @empty
                    <p class="text-center">{{ __('No Records Found!') }}</p>
                @endforelse
            </ul>
        </div>
    </div>
@endif
