<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th scope="col">{{ __('Message') }}</th>
                <th scope="col">{{ __('Time') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($globals_history as $value)
                <tr>
                    <td>{{ $value->Comment }}</td>
                    <td>{{ $value->EventTime }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center">{{ __('No Records Found!') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
