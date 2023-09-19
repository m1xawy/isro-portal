@php
    date_default_timezone_set(cache()->remember('server_timezone', 600, function() { return setting('server_timezone', 'UTC'); }));
    $schedules = cache()->remember('server_schedule', setting('cache_widget', 600), function() { return getServerTimes(); });
@endphp

<div class="server-times p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <div class="max-w-xl">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Event Schedule') }}</h2>

        <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
            <li class="py-3 sm:py-4">
                <div class="flex items-center space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                            {{ __('Server Time') }}
                        </p>
                    </div>
                    <div class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 font-medium">
                        <span id="idTimerClock">{{ date('H:i:s') }}</span>
                    </div>
                </div>
            </li>

            @php $i = 0; @endphp
            @foreach($schedules as $key => $schedule)
                @if(is_null($schedule)) @continue @endif
                <li class="py-3 sm:py-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                {{ config('schedule-label')[$key] }}
                            </p>
                        </div>
                        <div class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 font-medium">
                            @if($schedule['status'])
                                <span class="text-green-800">Active</span>
                            @else
                                <span class="timerCountdown" id="idTimeCountdown_{{ $i }}" data-time="{{ $schedule['start'] }}"></span>
                            @endif
                        </div>
                    </div>
                </li>
                @php $i++; @endphp
            @endforeach
        </ul>
    </div>
</div>
