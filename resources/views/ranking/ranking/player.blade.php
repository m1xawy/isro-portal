<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">#</th>
            <th scope="col" class="px-6 py-3">Name</th>
            <th scope="col" class="px-6 py-3">Guild</th>
            <th scope="col" class="px-6 py-3">Level</th>
            <th scope="col" class="px-6 py-3">Item Points</th>
        </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @forelse($players as $player)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row">{{ $i }}</th>
                    <td class="px-6 py-4"><a href="{{ route('ranking.character.view', ['name' => $player->CharName16]) }}">{{ $player->CharName16 }}</a></td>
                    @php if($player->GuildID > 0) : @endphp
                        <td class="px-6 py-4"><a href="{{ route('ranking.guild.view', ['name' => $player->getGuildUser->Name]) }}">{{ $player->getGuildUser->Name }}</a></td>
                    @php else : @endphp
                        <td class="px-6 py-4">None</td>
                    @php endif; @endphp
                    <td class="px-6 py-4">{{ $player->CurLevel }}</td>
                    <td class="px-6 py-4">0</td>
                </tr>
                @php $i++ @endphp
            @empty
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-center">
                    <td class="px-6 py-4" colspan="5">No Ranking available</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
