@extends('layouts.full')
@section('title', __('Event Times'))

@section('content')
    <div class="container">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Event Name</th>
                        <th>Remaining Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $const = config('constants.widgets.event_schedule.data');@endphp
                    @php $i = 0; @endphp
                    @foreach($timers as $key => $value)
                        @if(is_null($value)) @continue @endif
                        <tr>
                            <td>{{ $const[$key] }}</td>
                            <td>
                                <span class="timerCountdown" id="idTimeCountdown_{{ $i }}" data-time="{{ $value['start'] }}"></span>
                            </td>
                            <td>
                                @if($value['status'])
                                    <span class="text-success">Active</span>
                                @else
                                    <span class="text-warning">Planned</span>
                                @endif
                            </td>
                        </tr>
                        @php $i++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
