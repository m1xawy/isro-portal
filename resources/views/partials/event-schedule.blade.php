@if (config('constants.widgets.event_schedule.enable'))
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Event Schedule') }}
        </div>
        <div class="card-body">
            @php
                $schedules = getServerTimes();
                $const = config('constants.widgets.event_schedule.data');
            @endphp
            @php $i = 0; @endphp
            <ul class="list-unstyled">
                @foreach($schedules as $key => $value)
                    @if(is_null($value)) @continue @endif
                    <li>
                        <span>{{ $const[$key] }}</span>
                        <span class="float-end">
                            @if($value['status'])
                                <span class="text-success">Active</span>
                            @else
                                <span class="timerCountdown" id="idTimeCountdown_{{ $i }}" data-time="{{ $value['start'] }}"></span>
                            @endif
                        </span>
                    </li>
                    @php $i++; @endphp
                @endforeach
            </ul>

            <div class="d-grid mx-auto">
                <a href="{{ route('pages.timers') }}" class="btn btn-primary btn-sm">{{ __('Event Times') }}</a>
            </div>
        </div>
    </div>
@endif
