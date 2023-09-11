@extends('layouts.full')
@section('title', __('Ranking'))

@section('content')
    <div class="space-y-6">
        <div class="lg:flex lg:flex-wrap">
            <a href="#" class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800 active:bg-gray-900">Player Ranking</a>
            <a href="#" class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">Guild Ranking</a>
            <a href="#" class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">Unique Ranking</a>
        </div>

        <div class="text-gray-900 dark:text-gray-100 text-left mt-3">
            <h1>Player Ranking</h1>
        </div>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">#</th>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">Level</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                        @forelse($rankings as $ranking)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row">{{ $i }}</th>
                                <td class="px-6 py-4">{{ $ranking->CharName16 }}</td>
                                <td class="px-6 py-4">{{ $ranking->CurLevel }}</td>
                            </tr>
                            @php $i++ @endphp
                        @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">No Ranking available</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
