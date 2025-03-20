@extends('layouts.full')
@section('title', __('Global History'))

@section('content')
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 py-4">Global History</h2>
            <div class="relative overflow-x-auto">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="text-left">
                            <th scope="col" class="px-6 py-3">Message</th>
                            <th scope="col" class="px-6 py-3">Character</th>
                            <th scope="col" class="px-6 py-3">Date</th>
                        </tr>
                        </thead>
                        <tbody>

                        @if (!empty($globalHistory))
                            @foreach($globalHistory as $History)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th class="px-6 py-4" scope="row" style="color: gold">
                                    [ {{ $History->Comment }} ]
                                </th>
                                <td class="px-6 py-4">
                                    @if(!empty($History->CharName))
                                        <a href="{{ route('ranking.character.view', ['name' => $History->CharName]) }}">{{ $History->CharName }}</a>
                                    @else
                                        None
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ $History->EventTime }}
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-center">
                                <td class="px-6 py-4" colspan="4">No Records available</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
