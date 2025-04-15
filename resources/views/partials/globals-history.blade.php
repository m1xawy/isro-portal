@if (config('global.widgets.globals_history.enable'))
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Global History') }}
        </div>
        <div class="card-body">
            @if (!empty($global_history))
                <ul class="list-unstyled">
                    @foreach($global_history as $value)
                        <li class="mb-3">
                            <p class="mb-0">[{{ $value->Comment }}]</p>
                            <small>
                                {{ __('Sent by:') }}
                                <a href="{{ route('ranking.character.view', ['name' => $value->CharName]) }}" class="text-decoration-none">{{ $value->CharName }}</a>
                                {{ \Carbon\Carbon::make($value->EventTime)->diffForHumans() }}
                            </small>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-center">{{ __('No Records Found!') }}</p>
            @endif
        </div>
    </div>
@endif
