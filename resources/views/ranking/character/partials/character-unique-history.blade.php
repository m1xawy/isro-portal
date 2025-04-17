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
            @forelse($unique_history as $value)
                <tr>
                    <td>{{ config('global.ranking.unique_points')[$value->Value]['name'] }}</td>
                    <td>+{{ config('global.ranking.unique_points')[$value->Value]['points'] }}</td>
                    <td>{{ $value->EventTime }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">{{ __('No Records Found!') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
