@if (cache()->remember('server_global_widget_enable', 600, function() { return setting('server_global_widget_enable'); }))
<div class="space-y-6">
    <div class="text-gray-900 dark:text-gray-100 text-left mt-3">
        <h1>Global Chat History</h1>
    </div>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">

            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Message</th>
                            <th scope="col" class="px-6 py-3">ago</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if (!empty($charGlobalHistory))
                        @forelse($charGlobalHistory->take(5) as $History)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $History->Comment }}</td>
                                <td class="px-6 py-4">{{ $History->EventTime }}</td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-center">
                                <td class="px-6 py-4" colspan="2">No History available</td>
                            </tr>
                        @endforelse
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
