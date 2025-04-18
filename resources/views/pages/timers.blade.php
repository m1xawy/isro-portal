@extends('layouts.full')
@section('title', __('Event Times'))

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>{{ __('Event Name') }}</th>
                                <th>{{ __('Remaining Time') }}</th>
                                <th>{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0; @endphp
                            @foreach($data as $key => $value)
                                @if(is_null($value)) @continue @endif
                                <tr>
                                    <td>{{ config('settings.widgets.event_schedule.data')[$key] }}</td>
                                    <td>
                                        <span class="timerCountdown" id="idTimeCountdown_{{ $i }}" data-time="{{ $value['start'] }}"></span>
                                    </td>
                                    <td>
                                        @if($value['status'])
                                            <span class="text-success">{{ __('Active') }}</span>
                                        @else
                                            <span class="text-warning">{{ __('Planned') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @php $i++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
