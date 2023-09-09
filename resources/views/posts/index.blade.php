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
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    No Posts available
                </div>
            </div>
       @endforelse
    </div>
@endsection
