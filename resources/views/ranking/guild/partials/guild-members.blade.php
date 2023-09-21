<div class="space-y-0">
    <div class="text-gray-900 dark:text-gray-100 text-center mt-3">
        <h1>Guild Members</h1>
    </div>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">

            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">#</th>
                            <th scope="col" class="px-6 py-3">Character Name</th>
                            <th scope="col" class="px-6 py-3">Join Date</th>
                            <th scope="col" class="px-6 py-3">Title</th>
                            <th scope="col" class="px-6 py-3">Donation (GB)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @forelse($guildMembers as $guildMember)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $i }}</td>
                                <td class="px-6 py-4"><a href="{{ route('ranking.character.view', ['name' => $guildMember->CharName]) }}">{{ $guildMember->CharName }}</a></td>
                                <td class="px-6 py-4">{{ date('d-m-Y', strtotime($guildMember->JoinDate)) }}</td>
                                <td class="px-6 py-4">
                                    @switch($guildMember->SiegeAuthority)
                                        @case(0)
                                            <span>Member</span>
                                            @break
                                        @case(1)
                                            <span>Leader</span>
                                            @break
                                        @case(2)
                                            <span>Deputy commander</span>
                                            @break
                                        @case(4)
                                            <span>Fortress manager</span>
                                            @break
                                        @case(8)
                                            <span>Production manager</span>
                                            @break
                                        @case(16)
                                            <span>Training manager</span>
                                            @break
                                        @case(32)
                                            <span>Military engineer</span>
                                            @break
                                        @default
                                            <span>Member</span>
                                    @endswitch
                                </td>
                                <td class="px-6 py-4">{{ $guildMember->GP_Donation }}</td>
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
        </div>
    </div>
</div>
