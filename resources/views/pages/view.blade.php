@extends('layouts.full')
@section('title', $post->title)

@section('content')
    <div class="card mb-4 p-0">
        <div class="card-header">
            {{ $post->title }}
        </div>
        <div class="card-body">
            {!! $post->content !!}
        </div>
    </div>
@endsection
