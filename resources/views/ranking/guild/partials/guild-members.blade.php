<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th scope="col">{{ __('Rank') }}</th>
                <th scope="col">{{ __('Character Name') }}</th>
                <th scope="col">{{ __('Join Date') }}</th>
                <th scope="col">{{ __('Title') }}</th>
                <th scope="col">{{ __('Donation (GB)') }}</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @forelse($guildMembers as $guildMember)
                <tr>
                    <td>{{ $i }}</td>
                    <td>
                        @if($guildMember->RefObjID > 2000)
                            <img src="{{ asset('images/com_kindred_europe.png') }}" width="16" height="16" alt=""/>
                        @else
                            <img src="{{ asset('images/com_kindred_china.png') }}" width="16" height="16" alt=""/>
                        @endif
                        <a href="{{ route('ranking.character.view', ['name' => $guildMember->CharName]) }}" class="text-decoration-none">{{ $guildMember->CharName }}</a>
                    </td>
                    <td>{{ date('d-m-Y', strtotime($guildMember->JoinDate)) }}</td>
                    <td>
                        @if($guildMember->SiegeAuthority > 0)
                            {{ config('global.ranking.guild.authority')[$guildMember->SiegeAuthority] }}
                        @else
                            {{ __('Member') }}
                        @endif
                    </td>
                    <td>{{ $guildMember->GP_Donation }}</td>
                </tr>
                @php $i++ @endphp
            @empty
                <tr>
                    <td colspan="5" class="text-center">{{ __('No Records Found!') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
