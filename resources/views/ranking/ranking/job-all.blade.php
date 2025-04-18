<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th scope="col">{{ __('Rank') }}</th>
                <th scope="col">{{ __('NickName') }}</th>
                <th scope="col">{{ __('Job') }}</th>
                <th scope="col">{{ __('JobLevel') }}</th>
                <th scope="col">{{ __('Points') }}</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @forelse($data as $value)
                <tr>
                    <td>
                        @if($i <= 3)
                            <img src="{{ asset(config('settings.ranking.top_icons')[$i]) }}" alt=""/>
                        @else
                            {{ $i }}
                        @endif
                    </td>
                    <td>
                        @if($value->RefObjID > 2000)
                            <img src="{{ asset(config('settings.ranking.race')[1]['icon']) }}" width="16" height="16" alt=""/>
                        @else
                            <img src="{{ asset(config('settings.ranking.race')[0]['icon']) }}" width="16" height="16" alt=""/>
                        @endif
                        <a href="{{ route('ranking.character.view', ['name' => $value->CharName16]) }}" class="text-decoration-none">{{ $value->NickName16 }}</a>
                    </td>
                    <td>
                        <img src="{{ asset(config('settings.ranking.job_type_icons')[$value->JobType]['small_icon']) }}" alt=""/>
                        {{ config('settings.ranking.job_type_icons')[$value->JobType]['name'] }}
                    </td>
                    <td>{{ $value->JobLevel }}</td>
                    <td>{{ $value->JobExp }}</td>
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
