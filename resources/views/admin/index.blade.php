@extends('admin.layouts.app')
@section('title', __('Home DashBoard'))

@section('content')
    <div class="container">
        {{ $data }}
    </div>
@endsection
