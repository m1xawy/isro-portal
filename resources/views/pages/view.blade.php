@extends('layouts.full')
@section('title', $data->title)

@section('content')
    <div class="container">
        <div class="card mb-4 p-0">
            <div class="card-header">
                {{ $data->title }}
            </div>
            <div class="card-body">
                {!! $data->content !!}
            </div>
        </div>
    </div>
@endsection
