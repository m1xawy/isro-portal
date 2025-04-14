@extends('layouts.app')
@section('title', __('Donate History'))

@section('content')
    <div class="container">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">{{ __('Serial') }}</th>
                        <th scope="col">{{ __('Remained Silk') }}</th>
                        <th scope="col">{{ __('Changed Silk') }}</th>
                        <th scope="col">{{ __('Silk Type') }}</th>
                        <th scope="col">{{ __('Date') }}</th>
                        <th scope="col">{{ __('Expire Date') }}</th>
                        <th scope="col">{{ __('Status') }}</th>
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
                            <td colspan="7" class="text-center">{{ __('No Records Found!') }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
