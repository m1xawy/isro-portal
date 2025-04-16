<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-dark">
        <tr>
            <th scope="col">{{ __('Unique Name') }}</th>
            <th scope="col">{{ __('Points') }}</th>
            <th scope="col">{{ __('Time') }}</th>
        </tr>
        </thead>
        <tbody>
        @forelse($charUniqueHistory as $value)
            <tr>
                <td class="px-6 py-4">{{ config('global.ranking.unique_points')[$value->MobID]['name'] }}</td>
                <td class="px-6 py-4">+{{ config('global.ranking.unique_points')[$value->MobID]['points'] }}</td>
                <td class="px-6 py-4">{{ $value->EventDate }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">{{ __('No Records Found!') }}</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
