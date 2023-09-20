@php
    $unique_list_settings = cache()->remember('ranking_unique_list', setting('cache_ranking_unique', 600), function() { return json_decode(setting('ranking_unique_list')); });

    if($unique_list_settings) {
        foreach ($unique_list_settings as $unique_settings) {
            $unique_settings_array[] = $unique_settings->attributes;
            $unique_name = array_column($unique_settings_array, 'ranking_unique_name', 'ranking_unique_id');
            $unique_point = array_column($unique_settings_array, 'ranking_unique_point', 'ranking_unique_id');
        }
    }
@endphp

<div class="space-y-6">
    <div class="text-gray-900 dark:text-gray-100 text-left mt-3">
        <h1>Unique History</h1>
    </div>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">

            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Unique Name</th>
                            <th scope="col" class="px-6 py-3">Points</th>
                            <th scope="col" class="px-6 py-3">ago</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($charUniqueHistory))
                            @foreach($charUniqueHistory->take(5) as $uniqueHistory)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">{{ $unique_name[$uniqueHistory->MobID] }}</td>
                                    <td class="px-6 py-4">+{{ $unique_point[$uniqueHistory->MobID] }}</td>
                                    <td class="px-6 py-4">{{ $uniqueHistory->EventDate }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-center">
                                <td class="px-6 py-4" colspan="3">No Ranking available</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
