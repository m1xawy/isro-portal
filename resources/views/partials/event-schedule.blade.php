@if (config('global.widgets.event_schedule.enable'))
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Event Schedule') }}
        </div>
        <div class="card-body">
            @php $i = 0; @endphp
            <ul class="list-unstyled">
                @foreach($event_schedule as $key => $value)
                    @if(is_null($value)) @continue @endif
                    <li>
                        <span>{{ config('global.widgets.event_schedule.data')[$key] }}</span>
                        <span class="float-end">
                            @if($value['status'])
                                <span class="text-success">{{ __('Active') }}</span>
                            @else
                                <span class="timerCountdown" id="idTimeCountdown_{{ $i }}" data-time="{{ $value['start'] }}"></span>
                            @endif
                        </span>
                    </li>
                    @php $i++; @endphp
                @endforeach
            </ul>
        </div>
    </div>
@endif
