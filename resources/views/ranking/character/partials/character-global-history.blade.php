<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th scope="col">Message</th>
                <th scope="col">Time</th>
            </tr>
        </thead>
        <tbody>
            @forelse($charGlobalHistory as $value)
                <tr>
                    <td>{{ $value->Comment }}</td>
                    <td>{{ $value->EventTime }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center">No Records Found!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
