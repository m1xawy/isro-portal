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
                                        @php else : @endphp
                                        <img src="{{ asset('images/ingame/chinese.png') }}" class="inline-block" style="vertical-align:text-top" alt="Rank 3"/>
                                        <span>Chinese</span>
                                        @php endif; @endphp
                                    </td>
                                </tr>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">Level:</td>
                                    <td class="px-6 py-4">{{ $characters->CurLevel }} / {{ $characters->CurLevel }}</td>
                                </tr>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">Item Points:</td>
                                    <td class="px-6 py-4">{{ $characters->ItemPoints }}</td>
                                </tr>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">Title:</td>
                                    <td class="px-6 py-4">[ ]</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="md:w-1/2 p-4">
                        <!-- Inventory -->
                        <section class="relative border dark:bg-gray-800 dark:border-gray-700 bg-cover bg-center bg-no-repeat bg-gray-700" style="background-image: url({{ asset('images/ingame/inventoryDiv_bg.png') }})">
                            <div class="px-4 mx-auto max-w-screen-xl text-center py-8">
                                <div class="flex flex-row sm:flex-row sm:justify-center">
                                    <div class="bg-center bg-no-repeat" style="background-image: url({{ asset('images/ingame/inventory_bg.png') }}); width: 178px; height: 315px"></div>
                                    <div class="bg-center bg-no-repeat" style="background-image: url({{ asset('images/ingame/accessory_bg.png') }}); width: 206px;"></div>
                                </div>
                            </div>

                            <div role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2 w-full h-full flex  justify-center items-center backdrop-brightness-50">
                                <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                                <span class="sr-only">Loading...</span>
                            </div>
                        </section>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('ranking.character.partials.character-unique-history')

@endsection
