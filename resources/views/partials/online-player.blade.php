@php
    $OnlineCount =  getOnlineCount();
    $MaxCount = setting('server_max_player', 999);
    $progress = ceil($OnlineCount*100/$MaxCount);
@endphp

<div class="server-times p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <div class="max-w-xl">
        <div class="flex justify-between mb-1">
            <span class="text-base font-medium text-blue-700 dark:text-white">{{ __('Online Player') }}</span>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $OnlineCount }} / {{ $MaxCount }}</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
            <div class="bg-indigo-700 h-3 rounded-full" style="width: {{ $progress }}%"></div>
        </div>
    </div>
</div>
