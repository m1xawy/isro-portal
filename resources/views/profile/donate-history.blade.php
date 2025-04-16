@extends('layouts.app')
@section('title', __('Donate History'))

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
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
                        @forelse($data as $value)
                            <tr>
                                <td>{{ $value->PTInvoiceID }}</td>
                                <td style="color: orange">{{ $value->RemainedSilk }}</td>
                                <td style="color: orangered">{{ $value->ChangedSilk }}</td>
                                <td>{{ ($value->SilkType == 3) ? 'premium' : 'Normal' }}</td>
                                <td>{{ $value->ChangeDate }}</td>
                                <td>{{ $value->AvailableDate }}</td>
                                <td>{{ ($value->AvailableStatus == 'Y') ? "Available" : "Not Available" }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">{{ __('No Records Found!') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
