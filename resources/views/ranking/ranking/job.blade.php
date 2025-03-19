<div class="space-y-6">
    <div class="lg:flex lg:flex-wrap">
        <a href="javascript:void(0)" data-link="{{ route('ranking.job.all') }}" class="ranking-main-button-job text-indigo-700 hover:text-white border border-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-indigo-500 dark:text-indigo-500 dark:hover:text-white dark:hover:bg-indigo-500 dark:focus:ring-indigo-800">All</a>
        <a href="javascript:void(0)" data-link="{{ route('ranking.job.hunter') }}" class="ranking-main-button-job text-indigo-700 hover:text-white border border-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-indigo-500 dark:text-indigo-500 dark:hover:text-white dark:hover:bg-indigo-500 dark:focus:ring-indigo-800">Hunters</a>
        <a href="javascript:void(0)" data-link="{{ route('ranking.job.thieve') }}" class="ranking-main-button-job text-indigo-700 hover:text-white border border-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-indigo-500 dark:text-indigo-500 dark:hover:text-white dark:hover:bg-indigo-500 dark:focus:ring-indigo-800">Thieves</a>
        <a href="javascript:void(0)" data-link="{{ route('ranking.job.trader') }}" class="ranking-main-button-job text-indigo-700 hover:text-white border border-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-indigo-500 dark:text-indigo-500 dark:hover:text-white dark:hover:bg-indigo-500 dark:focus:ring-indigo-800">Traders</a>
    </div>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">

            <div id="content-replace-job">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3"></th>
                            <th scope="col" class="px-6 py-3">#</th>
                            <th scope="col" class="px-6 py-3">Race</th>
                            <th scope="col" class="px-6 py-3">NickName</th>
                            <th scope="col" class="px-6 py-3">Job</th>
                            <th scope="col" class="px-6 py-3">JobLevel</th>
                            <th scope="col" class="px-6 py-3">Points</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                        @forelse($job as $player)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th class="w-0" scope="row">
                                    @switch($i)
                                        @case(1)
                                            <img src="{{ asset('images/ingame/rank1.png') }}" style="vertical-align:text-top" alt="Rank 1"/>
                                            @break
                                        @case(2)
                                            <img src="{{ asset('images/ingame/rank2.png') }}" style="vertical-align:text-top" alt="Rank 2"/>
                                            @break
                                        @case(3)
                                            <img src="{{ asset('images/ingame/rank3.png') }}" style="vertical-align:text-top" alt="Rank 3"/>
                                            @break
                                    @endswitch
                                </th>
                                <td class="px-6 py-4">
                                    {{ $i }}
                                </td>
                                <td class="px-6 py-4">
                                    @php if($player->RefObjID > 2000) : @endphp
                                    <img src="{{ asset('images/ingame/european.png') }}" style="vertical-align:text-top" alt="Rank 3"/>
                                    @php else : @endphp
                                    <img src="{{ asset('images/ingame/chinese.png') }}" style="vertical-align:text-top" alt="Rank 3"/>
                                    @php endif; @endphp
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('ranking.character.view', ['name' => $player->CharName16]) }}">{{ $player->NickName16 }}</a>
                                </td>
                                <td class="px-6 py-4">
                                    @php if($player->JobType == 1) : @endphp
                                    <img class="inline" src="{{ asset('images/ingame/com_job_thief.PNG') }}" alt=""/>
                                    <span>Thief</span>
                                    @php elseif($player->JobType == 2) : @endphp
                                    <img class="inline" src="{{ asset('images/ingame/com_job_hunter.PNG') }}" alt=""/>
                                    <span>Hunter</span>
                                    @php elseif($player->JobType == 3) : @endphp
                                    <img class="inline" src="{{ asset('images/ingame/com_job_merchant.PNG') }}" alt=""/>
                                    <span>Trader</span>
                                    @php else : @endphp
                                    <span>None</span>
                                    @php endif; @endphp
                                </td>
                                <td class="px-6 py-4">
                                    {{ $player->JobLevel }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $player->JobExp }}
                                </td>
                            </tr>
                            @php $i++ @endphp
                        @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-center">
                                <td class="px-6 py-4" colspan="7">No Ranking available</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="spinner" class="hidden">
                <div role="status" class="flex justify-center bg-blend-multiply">
                    <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-indigo-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery('.ranking-main-button-job').click(function() {
        jQuery('.ranking-main-button-job').removeClass('active');
        paginatorAjax('#content-replace-job', jQuery(this).data('link'));
        jQuery(this).addClass('active');
    });
</script>
