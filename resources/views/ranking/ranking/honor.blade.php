<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-dark">
        <tr>
            <th scope="col">{{ __('Rank') }}</th>
            <th scope="col">{{ __('Name') }}</th>
            <th scope="col">{{ __('Points') }}</th>
        </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @forelse($data as $value)
                <tr>
                    <td>
                        <img src="{{ asset(config('settings.ranking.honor_level')[$value->Rank]) }}" alt=""/>
                    </td>
                    <td>
                        @if($value->RefObjID > 2000)
                            <img src="{{ asset(config('settings.ranking.race')[1]['icon']) }}" width="16" height="16" alt=""/>
                        @else
                            <img src="{{ asset(config('settings.ranking.race')[0]['icon']) }}" width="16" height="16" alt=""/>
                        @endif
                        <a href="{{ route('ranking.character.view', ['name' => $value->CharName16]) }}" class="text-decoration-none">{{ $value->CharName16 }}</a>
                    </td>
                    <td>{{ $value->HonorPoint }}</td>
                </tr>
                @php $i++ @endphp
            @empty
                <tr>
                    <td colspan="3" class="text-center">{{ __('No Records Found!') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
