@extends('layouts.full')
@section('title', __('Ranking'))

@section('content')
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <div class="lg:flex lg:flex-wrap m-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="md:w-1/3">
                        <div class="w-full">
                            <div class="flex flex-row items-center pb-1">
                                <div class="ml-4">
                                    <h5 class="mb-1 text-4xl font-medium text-gray-900 dark:text-white" style="color: #ffc345">
                                        <img class="inline-block" src="/ranking/guild-crest/{{ $guilds->Icon }}" alt="" width="32" height="32">
                                        {{ $guilds->Name }}
                                    </h5>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Foundation Date <span style="color: #ffc345">{{ date('d-m-Y', strtotime($guilds->FoundationDate)) }}</span></p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Rank <span style="color: #ffc345">#</span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="md:w-2/3">
                        <div class="lg:flex lg:flex-wrap justify-between h-full items-end">
                            <div class="md:w-1/4">
                                <div class="w-full">
                                    <div class="flex flex-col items-center pb-0">
                                        <h2 class="mb-3 text-xl font-bold text-gray-900 dark:text-white" style="color: #ffc345">{{ $guilds->Leader }}</h2>
                                        <span class="text-xs font-bold uppercase text-gray-900 dark:text-white">Leader</span>
                                    </div>
                                </div>
                            </div>
                            <div class="md:w-1/4">
                                <div class="w-full">
                                    <div class="flex flex-col items-center pb-0">
                                        <h2 class="mb-3 text-xl font-bold text-gray-900 dark:text-white" style="color: #ffc345">{{ $guilds->ItemPoints }}</h2>
                                        <span class="text-xs font-bold uppercase text-gray-900 dark:text-white">Item Points</span>
                                    </div>
                                </div>
                            </div>
                            <div class="md:w-1/4">
                                <div class="w-full">
                                    <div class="flex flex-col items-center pb-0">
                                        <h2 class="mb-3 text-4xl font-bold text-gray-900 dark:text-white" style="color: #ffc345">{{ $guilds->Lvl }}</h2>
                                        <span class="text-xs font-bold uppercase text-gray-900 dark:text-white">Level</span>
                                    </div>
                                </div>
                            </div>
                            <div class="md:w-1/4">
                                <div class="w-full">
                                    <div class="flex flex-col items-center pb-0">
                                        <h2 class="mb-3 text-4xl font-bold text-gray-900 dark:text-white" style="color: #ffc345">{{ $guilds->Members }}</h2>
                                        <span class="text-xs font-bold uppercase text-gray-900 dark:text-white">Members</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @include('ranking.guild.partials.guild-members')
                @include('ranking.guild.partials.guild-alliances')

            </div>
        </div>
    </div>
@endsection
