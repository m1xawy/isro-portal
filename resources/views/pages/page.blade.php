@extends('layouts.full')
@section('title', $page['name']['en'])

@section('content')
    <div class="container">
        <div class="card mb-4 p-0">
            <div class="card-header">
                {{ $page['name']['en'] }}
            </div>
            <div class="card-body">
                @if(!empty($page['data']))
                    {!! $page['data']['en']['content'] !!}
                @endif
            </div>
        </div>
    </div>
@endsection
