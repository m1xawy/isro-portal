<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3"></th>
            <th scope="col" class="px-6 py-3">#</th>
            <th scope="col" class="px-6 py-3">Race</th>
            <th scope="col" class="px-6 py-3">NickName</th>
            <th scope="col" class="px-6 py-3">JobLevel</th>
            <th scope="col" class="px-6 py-3">Points</th>
        </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @forelse($jobThieve as $player)
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
