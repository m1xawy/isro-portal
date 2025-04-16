@extends('layouts.full')
@section('title', __('Character') . ' - ' .$characters->CharName16)

@section('content')
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <div class="lg:flex lg:flex-wrap m-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="md:w-1/2">
                        <div class="w-full">
                            <div class="flex flex-row items-center pb-1">
                                <div class="w-24 h-24 rounded-md shadow-lg border-2 overflow-hidden">
                                    <img class="object-cover scale-125" src="{{ asset(config('global.ranking.character')[$characters->RefObjID]) }}" alt="{{ $characters->CharName16 }}"/>
                                </div>
                                <div class="ml-4">
                                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $characters->CharName16 }}</h5>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Item Points: <span style="color: #ffc345">{{ $characters->ItemPoints }}</span></span>
                                    <ul class="character-build flex flex-row mt-3">
                                        @foreach($charBuildInfo as $build)
                                            <li><img src="{{ asset(config('global.ranking.skill_mastery')[$build->MasteryID]['icon']) }}" title="{{ config('global.ranking.skill_mastery')[$build->MasteryID]['name'] }}"></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="md:w-1/2">
                        <div class="lg:flex lg:flex-wrap justify-between">
                            <div class="md:w-1/3">
                                <div class="w-full">
                                    <h4 class="pb-4 text-sm" style="color: #ffc345">Job informations</h4>
                                    <div class="flex flex-row items-center pb-2 mt-2">
                                        <img src="{{ asset(config('global.ranking.job_type_icons')[$characters->JobType]['icon']) }}" alt=""/>

                                        <div class="ml-3">
                                            <h5 class="text-xs font-bold text-black dark:text-white text-left">
                                                <span>{{ config('global.ranking.job_type_icons')[$characters->JobType]['name'] }}</span>
                                            </h5>
                                            <h5 class="text-xs font-bold text-black dark:text-white text-center">Job Level: {{ $characters->JobLevel }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="md:w-1/3">
                                <div class="w-full">
                                    <h4 class="pb-4 text-sm" style="color: #ffc345">Other informations</h4>
                                    <div class="flex flex-row items-center pb-2">
                                        <img class="" src="{{ asset('images/ingame/item_hp_potion.png') }}" alt=""/>

                                        <div class="ml-3" style="background-image: url({{ asset('images/ingame/hp_bar.png') }}); width: 91px; height: 12px">
                                            <h5 class="text-xs font-bold text-white dark:text-white text-center">{{ $characters->HP }}</h5>
                                        </div>
                                    </div>
                                    <div class="flex flex-row items-center pb-0">
                                        <img class="" src="{{ asset('images/ingame/item_mp_potion.png') }}" alt=""/>

                                        <div class="ml-3" style="background-image: url({{ asset('images/ingame/mp_bar.png') }}); width: 91px; height: 12px">
                                            <h5 class="text-xs font-bold text-white dark:text-white text-center">{{ $characters->MP }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="md:w-1/3">
                                <div class="w-full">
                                    <h4 class="pb-4 text-sm" style="color: #ffc345">Character Configuration</h4>
                                    <div class="flex flex-row items-center pb-4">
                                        <img class="" src="{{ asset('images/ingame/plus_button.png') }}" alt=""/>
                                        <h5 class="ml-1 text-xs font-bold text-gray-900 dark:text-white" style="color: #ffc345">{{ $characters->Strength }}</h5>
                                        <span class="ml-2 text-xs font-bold text-gray-900 dark:text-white">Strength (STR)</span>
                                    </div>
                                    <div class="flex flex-row items-center pb-0">
                                        <img class="" src="{{ asset('images/ingame/plus_button.png') }}" alt=""/>
                                        <h5 class="ml-1 text-xs font-bold text-gray-900 dark:text-white" style="color: #ffc345">{{ $characters->Intellect }}</h5>
                                        <span class="ml-2 text-xs font-bold text-gray-900 dark:text-white">Intellect (INT)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:flex lg:flex-wrap">
                    <div class="md:w-1/2 py-4">
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <tbody>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">Character Name:</td>
                                    <td class="px-6 py-4">{{ $characters->CharName16 }}</td>
                                </tr>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">Jobname:</td>
                                    <td class="px-6 py-4">{{ $characters->NickName16 }}</td>
                                </tr>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">Guild:</td>
                                    <td class="px-6 py-4">
                                        @php if($characters->GuildID > 0) : @endphp
                                        <a href="{{ route('ranking.guild.view', ['name' => $characters->GuildName]) }}">{{ $characters->GuildName }}</a>
                                        @php else : @endphp
                                        <span>None</span>
                                        @php endif; @endphp
                                    </td>
                                </tr>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">Race:</td>
                                    <td class="px-6 py-4">
                                        @php if($characters->RefObjID > 2000) : @endphp
                                            <img src="{{ asset('images/ingame/european.png') }}" class="inline-block" style="vertical-align:text-top" alt="Rank 3"/>
                                            <span>Europe</span>
                                            @php $race = 'EU'; @endphp
                                        @php else : @endphp
                                            <img src="{{ asset('images/ingame/chinese.png') }}" class="inline-block" style="vertical-align:text-top" alt="Rank 3"/>
                                            <span>Chinese</span>
                                            @php $race = 'CH'; @endphp
                                        @php endif; @endphp
                                    </td>
                                </tr>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">Level:</td>
                                    <td class="px-6 py-4">{{ $characters->CurLevel }} / 140</td>
                                </tr>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">Item Points:</td>
                                    <td class="px-6 py-4">{{ $characters->ItemPoints }}</td>
                                </tr>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">Title:</td>
                                    <td class="px-6 py-4" style="color: #ffc345">
                                        [
                                        @php if($characters->HwanLevel > 0) : @endphp
                                            {{ config('global.ranking.hwan_titles')[$race][$characters->HwanLevel] }}
                                        @php endif; @endphp
                                        ]
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <style>.d-none {display: none}</style>
                    <div class="md:w-1/2 p-4">
                        <div class="relative border dark:bg-gray-800 dark:border-gray-700 bg-cover bg-center bg-no-repeat bg-gray-700" style="background-image: url({{ asset('images/ingame/inventoryDiv_bg.png') }})">
                            <div class="px-4 mx-auto max-w-screen-xl text-center py-8">
                                <div class="flex flex-row sm:flex-row sm:justify-center">
                                    <div class="bg-center bg-no-repeat" id="display-inventory-set" style="background-image: url({{ asset('images/ingame/inventory_bg.png') }}); width: 178px; height: 315px">
                                        @include('ranking.character.partials.inventory.inventory-view', ['inventorySetList' => $playerInventory])
                                    </div>
                                    <div class="bg-center bg-no-repeat d-none" id="display-inventory-avatar" style="background-image: url({{ asset('images/ingame/inventory_bg.png') }}); width: 178px; height: 315px;">
                                        @include('ranking.character.partials.inventory.inventory-job-view', ['inventoryJobList' => $playerJob])
                                    </div>
                                    <div class="bg-equipment-job-main bg-center bg-no-repeat flex flex-col justify-end" style="background-image: url({{ asset('images/ingame/accessory_bg.png') }}); width: 206px; background-position: bottom">
                                        <button id="display-inventory-switch" data-type="set" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 transition ease-in-out duration-150 ml-3" style="margin-bottom: 1rem">
                                            Job Equip
                                        </button>

                                        <p class="text-capitalize text-left" style="color: #ffc345; margin-left: 1.6rem; margin-bottom: 0.6rem">Accessories</p>
                                        @include('ranking.character.partials.inventory.inventory-avatar-view', ['inventoryAvatarList' => $playerAvatar])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('ranking.character.partials.character-global-history')
    @include('ranking.character.partials.character-unique-history')

@endsection
@section('styles')
    <link href="{{ asset('/css/main.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/main.js') }}"></script>
    <style>
        /********CUSTOM INV********/
        .sro-item-detail .tooltip {
            text-align: left !important;
            font-size: 12px;
            width: 250px;
            min-height: 200px;
            background-color: rgba(28, 30, 52, .8);
            color: #fff;
            padding: 6px;
            border: 1px solid #808bba;
            border-radius: 5px;
            box-shadow: none;
            z-index: 999;
        }

        .table.table-inventory {
            margin: 0;
            width: 178px;
        }
        .table.table-inventory tr:first-child td {
            padding: 12px 12px 35px;
        }
        .table.table-inventory td, .table.table-inventory th {
            padding: 5.5px 5px;
        }
        .sro-item-detail.sro-item-special {
            background: 0;
        }
        .sro-item-detail {
            background: 0;
            width: auto;
            margin: 0;
        }
        .table.table-inventory td:last-child {
            float: right;
        }
        .sro-item-detail .item {
            margin: 0;
            background: 0;
        }

        /********CUSTOM INV AVATAR********/
        .table.table-inventory-avatar {
            margin: -5px auto 12px;
            width: 158px;
        }
        .table.table-inventory-avatar tbody {
            display: flex;
        }
        .table.table-inventory-avatar tr:first-child td {
            padding: 6px;
        }
        .table.table-inventory-avatar td, .table.table-inventory-avatar th {
            padding: 6px;
        }
        .table.table-inventory-avatar td:last-child {
            float: right;
        }
    </style>
@endsection
