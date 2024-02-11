@extends('layouts.app')
@section('title', __('MaxiCard'))

@section('content')
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 py-4">MaxiCard</h2>
            <div class="relative overflow-x-auto">
                <div class="lg:flex lg:flex-wrap">
                    @forelse($maxicard as $data)
                        <div class="md:w-1/3 p-2">

                            <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                <div class="flex flex-col items-center py-4">
                                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $data->name }}</h5>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $data->description }}</span>
                                </div>
                            </div>

                        </div>
                    @empty
                        {{ __('donations.maxicard.empty') }}
                    @endforelse
                </div>

                <a href="{{ route('donate-maxicard-buy') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Buy Now
                </a>
            </div>
        </div>
    </div>
@endsection
