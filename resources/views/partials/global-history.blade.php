@if (setting('server_global_widget_enable'))
@php
    $GlobalHistory = getGlobalHistory();
@endphp

<div class="server-info p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <div class="max-w-xl">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Global History') }}</h2>

        <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
            @if (!empty($GlobalHistory))
                @foreach($GlobalHistory as $History)
                <li class="py-3 sm:py-4">
                    <div class="flex items-center space-x-4">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                            <span class="text-sm font-medium text-gray-900 truncate dark:text-white" style="color: gold">[ {{ $History->Comment }} ]</span><br>
                            <span class="inline-flex items-center text-sm text-gray-500 truncate dark:text-gray-400 font-medium">Sent by</span>
                            <span class="text-sm font-medium text-gray-900 truncate dark:text-white"><a href="{{ route('ranking.character.view', ['name' => $History->CharName]) }}">{{ $History->CharName }}</a></span>
                            <span class="inline-flex items-center text-sm text-gray-500 truncate dark:text-gray-400 font-medium">{{ \Carbon\Carbon::make($History->EventTime)->diffForHumans() }}</span>
                        </p>
                    </div>
                </li>
                @endforeach
            @else
                <p class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-center">No Records.</p>
            @endif
        </ul>

    </div>
</div>
@endif
