@extends('layouts.app')
@section('title', __('Donate History'))

@section('content')
    <div class="container">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Serial</th>
                        <th scope="col">Remained Silk</th>
                        <th scope="col">Changed Silk</th>
                        <th scope="col">Silk Type</th>
                        <th scope="col">Date</th>
                        <th scope="col">Expire Date</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($donateHistory))
                        @foreach($donateHistory as $history)
                            <tr>
                                <td>{{ $history->PTInvoiceID }}</td>
                                <td style="color: orange">{{ $history->RemainedSilk }}</td>
                                <td style="color: orangered">{{ $history->ChangedSilk }}</td>
                                <td>{{ ($history->SilkType == 3) ? 'premium' : 'Normal' }}</td>
                                <td>{{ $history->ChangeDate }}</td>
                                <td>{{ $history->AvailableDate }}</td>
                                <td>{{ ($history->AvailableStatus == 'Y') ? "Available" : "Not Available" }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center">No records found!</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
