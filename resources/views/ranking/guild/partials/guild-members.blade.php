<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Race</th>
                <th scope="col">Character Name</th>
                <th scope="col">Join Date</th>
                <th scope="col">Title</th>
                <th scope="col">Donation (GB)</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @forelse($guildMembers as $guildMember)
                <tr>
                    <td>{{ $i }}</td>
                    <td>
                        @if($guildMember->RefObjID > 2000)
                            <img src="{{ asset('images/ingame/european.png') }}" style="vertical-align:text-top" alt="Rank 3"/>
                        @else
                            <img src="{{ asset('images/ingame/chinese.png') }}" style="vertical-align:text-top" alt="Rank 3"/>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('ranking.character.view', ['name' => $guildMember->CharName]) }}">{{ $guildMember->CharName }}</a>
                    </td>
                    <td>{{ date('d-m-Y', strtotime($guildMember->JoinDate)) }}</td>
                    <td>
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
                    <td>{{ $guildMember->GP_Donation }}</td>
                </tr>
                @php $i++ @endphp
            @empty
                <tr>
                    <td colspan="5" class="text-center">No Records Found!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
