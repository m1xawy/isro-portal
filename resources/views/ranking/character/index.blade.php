@extends('layouts.full')
@section('title', __('Character') . ' - ' .$characters->CharName16)

@section('content')
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <div class="lg:flex lg:flex-wrap m-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="md:w-2/3">
                        <div class="w-full">
                            <div class="flex flex-row items-center pb-1">
                                <div class="w-24 h-24 rounded-md shadow-lg border-2 overflow-hidden">
                                    <img class="object-cover scale-125" src="{{ asset('images/ingame/chars/'. $characters->RefObjID .'.gif') }}" alt="{{ $characters->CharName16 }}"/>
                                </div>
                                <div class="ml-4">
                                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $characters->CharName16 }}</h5>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Item Points: <span style="color: #ffc345">{{ $characters->ItemPoints }}</span></span>
                                    <ul class="character-build flex flex-row mt-3">
                                        @foreach($charBuildInfo as $build)
                                            <li><img src="{{ asset('images/ingame/skillmastery/'. config('mastery-build')[$build->MasteryID]['icon']) }}" title="{{ config('mastery-build')[$build->MasteryID]['name'] }}"></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="md:w-1/3">
                        <div class="lg:flex lg:flex-wrap justify-between">
                            <div class="md:w-1/2">
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

                            <div class="md:w-1/2">
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
                                    <td class="px-6 py-4">Nickname:</td>
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
                                            {{ config('hwan-level')[$race][$characters->HwanLevel] }}
                                        @php endif; @endphp
                                        ]
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="md:w-1/2 p-4">
                        <div class="relative border dark:bg-gray-800 dark:border-gray-700 bg-cover bg-center bg-no-repeat bg-gray-700" style="background-image: url({{ asset('images/ingame/inventoryDiv_bg.png') }})">
                            <div class="px-4 mx-auto max-w-screen-xl text-center py-8">
                                <div class="flex flex-row sm:flex-row sm:justify-center">
                                    <div class="bg-center bg-no-repeat" style="background-image: url({{ asset('images/ingame/inventory_bg.png') }}); width: 178px; height: 315px">
                                        @include('ranking.character.partials.inventory', ['items' => $playerInventory])
                                    </div>
                                    <div class="bg-equipment-avatar-main bg-center bg-no-repeat flex flex-col justify-end" style="background-image: url({{ asset('images/ingame/accessory_bg.png') }}); width: 206px; background-position: bottom">
                                        <p class="text-capitalize text-left" style="color: #ffc345; margin-left: 1.6rem; margin-bottom: 0.6rem">Accessories</p>
                                        @include('ranking.character.partials.inventoryAvatar', ['items' => $playerInventory])
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
