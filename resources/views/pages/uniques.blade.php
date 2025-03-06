@extends('layouts.full')
@section('title', __('Unique History'))

@section('content')
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 py-4">Unique History</h2>
            <div class="relative overflow-x-auto">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="text-center">
                            <th scope="col" class="px-1 py-2">Unique</th>
                            <th scope="col" class="px-1 py-2">Dead Time</th>
                            <th scope="col" class="px-1 py-2">Killer</th>
                            <th scope="col" class="px-1 py-2">Area</th>
                        </tr>
                        </thead>
                        <tbody>

                        @php $i = 0; @endphp
                        @foreach($uniques as $key => $unique)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-center">
                                <td class="px-1 py-2">{{ $uniques_name[$unique->Value] }}</td>
                                <td class="px-1 py-2">{{ $unique->EventTime }}</td>
                                <td class="px-1 py-2 text-left">
                                    @php if($unique->RefObjID > 2000) : @endphp
                                    <img src="{{ asset('images/ingame/european.png') }}" style="display:inline;vertical-align:text-top" alt="Rank 3"/>
                                    @php else : @endphp
                                    <img src="{{ asset('images/ingame/chinese.png') }}" style="display:inline;vertical-align:text-top" alt="Rank 3"/>
                                    @php endif; @endphp

                                    {{ $unique->CharName16 }}
                                </td>
                                <td class="px-1 py-2">{{ $unique->AreaName }}</td>
                            </tr>
                            @php $i++; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
