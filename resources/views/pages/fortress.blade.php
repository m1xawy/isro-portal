@extends('layouts.full')
@section('title', __('Fortress History'))

@section('content')
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 py-4">Fortress History</h2>
            <div class="relative overflow-x-auto">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="text-left">
                            <th scope="col" class="px-6 py-3">Fortress</th>
                            <th scope="col" class="px-6 py-3">Winner</th>
                            <th scope="col" class="px-6 py-3">Date</th>
                        </tr>
                        </thead>
                        <tbody>

                        @php $i = 1; @endphp
                        @forelse($fortressHistory as $fortressGuild)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th class="px-6 py-4" scope="row">
                                    @switch($fortressGuild->FortressID)
                                        @case(1)
                                            <img src="{{ asset('images/ingame/jangan_fortress.png') }}" style="vertical-align:text-top;display: inline;" alt="Jangan Fortress"/>
                                            <span>Jangan Fortress</span>
                                            @break
                                        @case(3)
                                            <img src="{{ asset('images/ingame/hotan_fortress.png') }}" style="vertical-align:text-top;display: inline;" alt="Jangan Fortress"/>
                                            <span>Hotan Fortress</span>
                                            @break
                                        @case(4)
                                            <img src="{{ asset('images/ingame/constantinople_fortress.png') }}" style="vertical-align:text-top;display: inline;" alt="Jangan Fortress"/>
                                            <span>Constantinople Fortress</span>
                                            @break
                                        @case(6)
                                            <img src="{{ asset('images/ingame/bandit_fortress.png') }}" style="vertical-align:text-top;display: inline;" alt="Jangan Fortress"/>
                                            <span>Bandit Fortress</span>
                                            @break
                                    @endswitch
                                </th>
                                <td class="px-6 py-4">
                                    @if(!empty($fortressGuild->strDesc))
                                        <a href="{{ route('ranking.guild.view', ['name' => $fortressGuild->strDesc]) }}">{{ $fortressGuild->strDesc }}</a>
                                    @else
                                        None
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ $fortressGuild->EventTime }}
                                </td>
                            </tr>
                            @php $i++ @endphp
                        @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-center">
                                <td class="px-6 py-4" colspan="4">No Ranking available</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
