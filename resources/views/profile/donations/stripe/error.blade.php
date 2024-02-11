@extends('layouts.app')
@section('title', __('Stripe'))

@section('content')
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 py-4">Stripe</h2>
            <div class="relative overflow-x-auto">

                <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
                    <p class="font-bold">{{ __('donations.stripe.error.error-title') }}</p>
                    <p class="text-sm">{{ __('donations.stripe.error.error-body') }}</p>
                </div>

                <a href="{{ route('profile.donate') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    {{ __('donations.notification.buy.error-ahref') }}
                </a>

            </div>
        </div>
    </div>
@endsection
