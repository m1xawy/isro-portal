@extends('layouts.app')
@section('title', __('Profile'))

@section('content')
    @php
        $paypal_packages = cache()->remember('donate_paypal_price_list', 600, function() { return json_decode(setting('donate_paypal_price_list')); });
        $maxigame_packages = cache()->remember('donate_maxigame_price_list', 600, function() { return json_decode(setting('donate_maxigame_price_list')); });
    @endphp

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 py-4">Donate</h2>
            <div class="relative overflow-x-auto">

                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Paypal</button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">Maxigame</button>
                        </li>
                    </ul>
                </div>
                <div id="myTabContent">
                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="lg:flex lg:flex-wrap">
                            @if (!empty($paypal_packages))
                                @foreach($paypal_packages as $paypal_package)
                                    <div class="md:w-1/3 p-2">

                                        <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                            <div class="flex flex-col items-center pb-10 py-4">
                                                @if (isset($paypal_package->attributes->donate_paypal_package_image))
                                                    <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="{{ $paypal_package->attributes->donate_paypal_package_image }}" alt="{{ $paypal_package->attributes->donate_paypal_package_title }}"/>
                                                @endif
                                                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $paypal_package->attributes->donate_paypal_package_title }}</h5>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $paypal_package->attributes->donate_paypal_package_desc }}</span>
                                                <div class="flex mt-4 space-x-3 md:mt-6">
                                                    <a href="#" onclick="alert('not available, contact reseller')" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Buy Now</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            @else
                                No Packages.
                            @endif
                        </div>
                    </div>
                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                        <div class="lg:flex lg:flex-wrap">
                            @if (!empty($maxigame_packages))
                                @foreach($maxigame_packages as $maxigame_package)
                                    <div class="md:w-1/3 p-2">

                                        <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                            <div class="flex flex-col items-center pb-10 py-4">
                                                @if (isset($maxigame_package->attributes->donate_maxigame_package_image))
                                                    <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="{{ $maxigame_package->attributes->donate_maxigame_package_image }}" alt="{{ $maxigame_package->attributes->donate_maxigame_package_title }}"/>
                                                @endif
                                                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $maxigame_package->attributes->donate_maxigame_package_title }}</h5>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $maxigame_package->attributes->donate_maxigame_package_desc }}</span>
                                                <div class="flex mt-4 space-x-3 md:mt-6">
                                                    <a href="#" onclick="alert('not available, contact reseller')" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Buy Now</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            @else
                                No Packages.
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
