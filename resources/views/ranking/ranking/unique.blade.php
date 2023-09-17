<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Rank</th>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3">Race</th>
                <th scope="col" class="px-6 py-3">Name</th>
                <th scope="col" class="px-6 py-3">Guild</th>
                <th scope="col" class="px-6 py-3">Level</th>
                <th scope="col" class="px-6 py-3">Points</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @forelse($uniques as $unique)
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
                        @php if($unique->RefObjID > 2000) : @endphp
                        <img src="{{ asset('images/ingame/european.png') }}" style="vertical-align:text-top" alt="Rank 3"/>
                        @php else : @endphp
                        <img src="{{ asset('images/ingame/chinese.png') }}" style="vertical-align:text-top" alt="Rank 3"/>
                        @php endif; @endphp
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('ranking.character.view', ['name' => $unique->CharName16]) }}">{{ $unique->CharName16 }}</a>
                    </td>
                    <td class="px-6 py-4">
                        @php if($unique->ID > 0) : @endphp
                        <a href="{{ route('ranking.guild.view', ['name' => $unique->Name]) }}">{{ $unique->Name }}</a>
                        @php else : @endphp
                        <span>None</span>
                        @php endif; @endphp
                    </td>
                    <td class="px-6 py-4">
                        {{ $unique->CurLevel }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $unique->Points }}
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

<div id="accordion-open" data-accordion="open" class="p-4 mt-3" style="width: 50%; margin: auto">
    <h2 id="accordion-open-heading-1">
        <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-open-body-1" aria-expanded="true" aria-controls="accordion-open-body-1">
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                </svg>
                Information?
            </span>
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
        </button>
    </h2>
    <div id="accordion-open-body-1" class="hidden_" aria-labelledby="accordion-open-heading-1">
        <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
            <p class="mb-2 text-gray-500 dark:text-gray-400 p-2">
                @forelse($unique_list_settings as $unique_list)
                    <span>{{ $unique_list->attributes->ranking_unique_name }} [{{ $unique_list->attributes->ranking_unique_point }} points]</span>,
                @empty
                    <span>Unique Ranking Not available</span>
                @endforelse
            </p>
        </div>
    </div>
</div>
<!--
<p class="mb-2 text-gray-500 dark:text-gray-400 text-center">Last Update <span>00-00-0000 00:00:00</span></p>
-->
