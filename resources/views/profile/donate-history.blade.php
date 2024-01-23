@extends('layouts.app')
@section('title', __('Donate History'))

@section('content')
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 py-4">Donate History</h2>
            <div class="relative overflow-x-auto">

                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-1 py-2">Serial</th>
                            <th scope="col" class="px-1 py-2">Remained Silk</th>
                            <th scope="col" class="px-1 py-2">Changed Silk</th>
                            <th scope="col" class="px-1 py-2">Silk Type</th>
                            <th scope="col" class="px-1 py-2">Date</th>
                            <th scope="col" class="px-1 py-2">Expire Date</th>
                            <th scope="col" class="px-1 py-2">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (!empty($donateHistory))
                            @foreach($donateHistory as $history)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-center">
                                    <td class="px-1 py-2">{{ $history->PTInvoiceID }}</td>
                                    <td class="px-1 py-2" style="color: orange">{{ $history->RemainedSilk }}</td>
                                    <td class="px-1 py-2" style="color: orangered">{{ $history->ChangedSilk }}</td>
                                    <td class="px-1 py-2">{{ ($history->SilkType == 3) ? 'premium' : 'Normal' }}</td>
                                    <td class="px-1 py-2">{{ $history->ChangeDate }}</td>
                                    <td class="px-1 py-2">{{ $history->AvailableDate }}</td>
                                    <td class="px-1 py-2">{{ ($history->AvailableStatus == 'Y') ? "Available" : "Not Available" }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-center">
                                <td class="px-6 py-4" colspan="5">No Records Available.</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
