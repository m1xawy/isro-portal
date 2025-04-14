@extends('layouts.app')
@section('title', __('Home'))

@section('hero')
    @include('partials.carousel')
@stop

@section('content')
    <div class="container">
        @forelse($posts as $value)
            <div class="card mb-4">
                @if ( $value->featured_image )
                <img src="{{ Storage::url($value->featured_image) }}" class="card-img-top" alt="...">
                @endif
                <div class="card-header">
                    <a href="{{ '/post/' . $value->slug }}" class="text-decoration-none">
                        <h5 class="card-title">{{ $value->title }}</h5>
                    </a>
                    <p class="card-text">{!! config('constants.general.news-category')[$value->category] !!} Published on {{ $value->published_at->format("M j, Y") }}</p>
                </div>
                <div class="card-body">
                    {!! $value->content !!}
                </div>
            </div>
        @empty
            <div class="alert alert-danger text-center" role="alert">
                No posts available!
            </div>
       @endforelse
    </div>
@endsection
