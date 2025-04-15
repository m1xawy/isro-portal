@extends('layouts.full')
@section('title', $data['name']['en'])

@section('content')
    <div class="container">
        <div class="card mb-4 p-0">
            <div class="card-header">
                {{ $data['name']['en'] }}
            </div>
            <div class="card-body">
                {!! $data['data']['en']['content'] !!}
            </div>
        </div>
    </div>
@endsection
