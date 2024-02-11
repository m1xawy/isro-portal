@extends('layouts.app')
@section('title', __('Donate'))

@section('content')
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 py-4">Donate</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('donations.text') }}</p>

            <div class="relative overflow-x-auto">
                @if ($error = Session::get('error'))
                    <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
                        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                        <p>{{ $error }}</p>
                    </div>
                @endif

                <div class="w-100 text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @forelse($donationMethods as $method)
                    <a href="{{ route('donations-method-index', ['method' => $method->method]) }}" type="button" class="relative inline-flex items-center w-full px-4 py-2 text-sm font-medium border-b border-gray-200 rounded-t-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-500 dark:focus:text-white">
                        <div style="padding-right: 25px; max-width: 140px">
                            <img src="{{ asset('/images/donations/' . $method->image) }}" class="img-fluid" alt="{{ $method->name }}" width="140">
                        </div>
                        <div>{{ $method->name }}</div>
                    </a>
                    @empty
                        <a type="button" class="relative inline-flex items-center w-full px-4 py-2 text-sm font-medium border-b border-gray-200 rounded-t-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-500 dark:focus:text-white">
                            {{ __('donations.no_methods') }}
                        </a>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
@endsection
