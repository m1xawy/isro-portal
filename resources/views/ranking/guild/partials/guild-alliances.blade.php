<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr class="text-center">
                <th scope="col">{{ __('Name') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($guildAlliances as $guildAlliance)
                <tr class="text-center">
                    <td>
                        <a href="{{ route('ranking.guild.view', ['name' => $guildAlliance->Name]) }}">{{ $guildAlliance->Name }}</a>
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
