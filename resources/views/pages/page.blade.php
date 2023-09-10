@extends('layouts.full')
@section('title', $page['name']['en'])

@section('content')
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $page['name']['en'] }}</h2>

            <div class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {!! $page['data']['en']['content'] !!}
            </div>
        </div>
    </div>
@endsection
