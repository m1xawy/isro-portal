@extends('layouts.app')
@section('title', __('Home'))

@section('content')
    <div class="space-y-6">
        @forelse($posts as $post)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-gray-900 dark:text-gray-100">
                    @if ( $post->featured_image )
                        <img class="object-cover object-center w-full lg:h-48 md:h-36" src="{{ Storage::url($post->featured_image) }}" alt="blog">
                    @endif
                    <div class="p-6">
                        <span class="inline-block p-2 mb-2 text-xs font-medium tracking-widest text-green-800 bg-green-200 rounded">Category</span>
                        <p>Published on {{ $post->published_at->format("M j, Y") }}</p>
                        <a href="/posts/{{ $post->slug }}" class="cursor-pointer">
                            <h1 class="mb-2 text-lg font-medium text-gray-900 dark:text-gray-100">{{ $post->title }}</h1>
                        </a>
                        <p class="mb-2 tracking-wide text-sm text-gray-600 dark:text-gray-400">
                            {!! $post->content !!}
                        </p>
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
