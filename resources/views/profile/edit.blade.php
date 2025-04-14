@extends('layouts.app')
@section('title', __('Profile'))

@section('content')
    <div class="container">
        <div class="mb-4">
            @include('profile.partials.update-profile-information-form')
        </div>
        <div class="mb-4">
            @include('profile.partials.update-password-form')
        </div>
        <div>
            {{--@include('profile.partials.delete-user-form')--}}
        </div>
    </div>
@endsection
