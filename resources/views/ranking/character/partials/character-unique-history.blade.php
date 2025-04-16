<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-dark">
        <tr>
            <th scope="col">Unique Name</th>
            <th scope="col">Points</th>
            <th scope="col">ago</th>
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
                <td colspan="3" class="text-center">No Records Found!</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
