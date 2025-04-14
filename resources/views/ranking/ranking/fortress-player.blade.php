<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-dark">
        <tr>
            <th scope="col"></th>
            <th scope="col">{{ __('Race') }}</th>
            <th scope="col">{{ __('Name') }}</th>
            <th scope="col">{{ __('Kills/Death') }}</th>
        </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @forelse($data as $value)
                <tr>
                    <td>
                        @if($i <= 3)
                            <img src="{{ asset(config('constants.ranking.top_icons')[$i]) }}" alt=""/>
                        @else
                            {{ $i }}
                        @endif
                    </td>
                    <td>
                        @if($value->RefObjID > 2000)
                            <img src="{{ asset('images/european.png') }}" alt=""/>
                        @else
                            <img src="{{ asset('images/chinese.png') }}" alt=""/>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('ranking.character.view', ['name' => $value->CharName16]) }}" class="text-decoration-none">{{ $value->CharName16 }}</a>
                    </td>
                    <td>
                        {{ $value->GuildWarKill }} / {{ $value->GuildWarKilled }}
                    </td>
                </tr>
                @php $i++ @endphp
            @empty
                <tr>
                    <td colspan="4" class="text-center">{{ __('No Records Found!') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
