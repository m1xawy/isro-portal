@extends('layouts.full')
@section('title', __('Server Timers'))

@section('content')
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 py-4">Server Timers</h2>
            <div class="relative overflow-x-auto">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="text-center">
                            <th scope="col" class="px-1 py-2">Event Name</th>
                            <th scope="col" class="px-1 py-2">Remaining Time & Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i = 0; @endphp
                        @foreach($timers as $key => $time)
                            @if(is_null($time)) @continue @endif
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-center">
                                <td class="px-1 py-2">{{ config('schedule-label')[$key] }}</td>
                                <td class="px-1 py-2">
                                    @if($time['status'])
                                        <span class="text-green-800">Active</span>
                                    @else
                                        <span class="timerCountdown" id="idTimeCountdown_{{ $i }}" data-time="{{ $time['start'] }}"></span>
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
