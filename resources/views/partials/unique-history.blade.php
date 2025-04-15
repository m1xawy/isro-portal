@if (config('global.widgets.unique_history.enable'))
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Unique History') }}
        </div>
        <div class="card-body">
            @if (!empty($unique_history))
                <ul class="list-unstyled">
                    @foreach($unique_history as $value)
                        <li class="mb-3">
                            <p class="mb-0">{{ config('global.ranking.unique_points')[$value->Value] }}</p>
                            <small>
                                {{ __('Killed by:') }}
                                <a href="{{ route('ranking.character.view', ['name' => $value->CharName16]) }}" class="text-decoration-none">{{ $value->CharName16 }}</a>
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
