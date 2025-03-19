<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3"></th>
            <th scope="col" class="px-6 py-3">#</th>
            <th scope="col" class="px-6 py-3">Race</th>
            <th scope="col" class="px-6 py-3">Name</th>
            <th scope="col" class="px-6 py-3">Points</th>
        </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @forelse($honor as $player)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th class="w-0" scope="row">
                        @switch($player->Rank)
                            @case(1)
                                <img src="{{ asset('images/ingame/com_honor_level_1.PNG') }}" style="vertical-align:text-top" alt="Rank 1"/>
                                @break
                            @case(2)
                                <img src="{{ asset('images/ingame/com_honor_level_2.PNG') }}" style="vertical-align:text-top" alt="Rank 2"/>
                                @break
                            @case(3)
                                <img src="{{ asset('images/ingame/com_honor_level_3.PNG') }}" style="vertical-align:text-top" alt="Rank 3"/>
                                @break
                            @case(4)
                                <img src="{{ asset('images/ingame/com_honor_level_4.PNG') }}" style="vertical-align:text-top" alt="Rank 4"/>
                                @break
                            @case(5)
                                <img src="{{ asset('images/ingame/com_honor_level_5.PNG') }}" style="vertical-align:text-top" alt="Rank 5"/>
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
                        <a href="{{ route('ranking.character.view', ['name' => $player->CharName16]) }}">{{ $player->CharName16 }}</a>
                    </td>
                    <td class="px-6 py-4">
                        {{ $player->HonorPoint }}
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
