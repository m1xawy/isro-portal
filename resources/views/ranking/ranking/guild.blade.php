<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-dark">
        <tr>
            <th scope="col"></th>
            <th scope="col">{{ __('Name') }}</th>
            <th scope="col">{{ __('Level') }}</th>
            <th scope="col">{{ __('Members') }}</th>
            <th scope="col">{{ __('Total Item Points') }}</th>
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
                        <a href="{{ route('ranking.guild.view', ['name' => $value->Name]) }}" class="text-decoration-none">{{ $value->Name }}</a>
                    </td>
                    <td>{{ $value->Lvl }}</td>
                    <td>{{ $value->TotalMember }}</td>
                    <td>{{ $value->ItemPoints }}</td>
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
