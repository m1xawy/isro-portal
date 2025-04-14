<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th scope="col">{{ __('Rank') }}</th>
                <th scope="col">{{ __('Name') }}</th>
                <th scope="col">{{ __('Guild') }}</th>
                <th scope="col">{{ __('Level') }}</th>
                <th scope="col">{{ __('Points') }}</th>
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
                        <a href="{{ route('ranking.character.view', ['name' => $value->CharName16]) }}" class="text-decoration-none">{{ $value->CharName16 }}</a>
                    </td>
                    <td>
                        @if($value->ID > 0)
                            <a href="{{ route('ranking.guild.view', ['name' => $value->Name]) }}" class="text-decoration-none">{{ $value->Name }}</a>
                        @else
                            <span>{{ __('None') }}</span>
                        @endif
                    </td>
                    <td>{{ $value->CurLevel }}</td>
                    <td>{{ $value->Points }}</td>
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


<p class="mb-2 text-center">
    @forelse($unique_lists as $unique_list)
        <span>{{ $unique_list->attributes->ranking_unique_name }} [{{ $unique_list->attributes->ranking_unique_point }} points]</span>,
    @empty
    @endforelse
</p>

<!--
<p class="mb-2 text-center">Last Update <span>00-00-0000 00:00:00</span></p>
-->
