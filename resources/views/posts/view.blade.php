@extends('layouts.full')
@section('title', $post->title)

@section('content')
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="text-gray-900 dark:text-gray-100">
            <div class="p-6">
                <h1 class="mb-2 text-lg font-medium text-gray-900 dark:text-gray-100">{{ $post->title }}</h1>

                <div class="mb-2 tracking-wide text-sm text-gray-600 dark:text-gray-400">
                    {!! $post->content !!}
                </div>
            </div>
        </div>
    </div>
@endsection
