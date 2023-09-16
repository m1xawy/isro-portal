@extends('layouts.app')
@section('title', __('Home'))

@section('header')
    @include('partials.slider')
@stop

@section('content')
    <div class="space-y-6">
        @forelse($posts as $post)
            @php
                switch ($post->category) {
                    case 'news':
                        $categoryClasses = 'text-yellow-800 bg-yellow-200';
                        break;
                    case 'update':
                        $categoryClasses = 'text-blue-800 bg-blue-200';
                        break;
                    case 'event':
                        $categoryClasses = 'text-green-800 bg-green-200';
                        break;
                    default:
                        $categoryClasses = 'text-gray-800 bg-gray-200';
                        break;
                }
            @endphp

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-gray-900 dark:text-gray-100">
                    @if ( $post->featured_image )
                        <img class="object-cover object-center w-full lg:h-48 md:h-36" src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}">
                    @endif
                    <div class="p-6">
                        <span class="inline-block p-2 px-4 mb-2 text-xs font-medium tracking-widest {{ $categoryClasses }} rounded">{{ $post->category }}</span>
                        <a href="/posts/{{ $post->slug }}" class="cursor-pointer">
                            <h1 class="mb-2 text-2xl font-medium text-gray-900 dark:text-gray-100">{{ $post->title }}</h1>
                        </a>
                        <p class="mb-2 text-sm">Published on {{ $post->published_at->format("M j, Y") }}</p>

                        <div class="mb-2 tracking-wide text-sm text-gray-600 dark:text-gray-400">
                            {!! $post->content !!}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="w-full flex justify-center">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative w-1/2 text-center" role="alert">
                    <span class="block sm:inline">No Posts available.</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                    </span>
                </div>
            </div>
       @endforelse
    </div>
@endsection
