@extends('layouts.app')
@section('title', __('Home'))

@section('breadcrumb')
    @include('partials.carousel')
@stop

@section('content')
    @forelse($posts as $post)
        <div class="card mb-4">
            @if ( $post->featured_image )
            <img src="{{ Storage::url($post->featured_image) }}" class="card-img-top" alt="...">
            @endif
            <div class="card-header">
                <a href="{{ '/post/' . $post->slug }}" class="text-decoration-none">
                    <h5 class="card-title">{{ $post->title }}</h5>
                </a>
                <p class="card-text">{!! config('constants.general.news-category')[$post->category] !!} Published on {{ $post->published_at->format("M j, Y") }}</p>
            </div>
            <div class="card-body">
                {!! $post->content !!}
            </div>
        </div>
    @empty
        <div class="alert alert-danger" role="alert">
            No Posts available!
        </div>
   @endforelse
@endsection
