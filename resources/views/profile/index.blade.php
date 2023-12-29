@extends('layouts.app')
@section('title', __('Profile'))

@section('content')
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 py-4">Account Info</h2>

            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Username
                        </th>
                        <td class="px-6 py-4">
                            {{ $user->username }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Email
                        </th>
                        <td class="px-6 py-4">
                            {{ $user->email }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Premium Silk
                        </th>
                        <td class="px-6 py-4">
                            {{ $user->getJCash()->PremiumSilk }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Month Usage
                        </th>
                        <td class="px-6 py-4">
                            {{ $user->getJCash()->MonthUsage }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            3Month Usage
                        </th>
                        <td class="px-6 py-4">
                            {{ $user->getJCash()->ThreeMonthUsage }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Silk
                        </th>
                        <td class="px-6 py-4">
                            {{ $user->getJCash()->Silk }}
                        </td>
                    </tr>
                    <tr class="bg-white dark:bg-gray-800">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            VIP
                        </th>
                        <td class="px-6 py-4">
                            @php if($user->getVIPInfo() !== null && $user->getVIPInfo()->VIPUserType > 0) : @endphp
                                <img src="{{ asset('images/ingame/viplevel_'.$user->getVIPInfo()->VIPLv.'.jpg') }}" class="inline-block w-6 mr-1"><span>{{ config('vip-info')['level'][$user->getVIPInfo()->VIPLv] }}</span>
                            @php else : @endphp
                                None
                            @php endif; @endphp
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
