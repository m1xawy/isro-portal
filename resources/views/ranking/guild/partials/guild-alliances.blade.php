<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr class="text-center">
                <th scope="col">{{ __('Name') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data_alliances as $value)
                <tr class="text-center">
                    <td>
                        <a href="{{ route('ranking.guild.view', ['name' => $value]) }}" class="text-decoration-none">{{ $value }}</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="1" class="text-center">{{ __('No Records Found!') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
