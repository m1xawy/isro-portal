@extends('layouts.app')
@section('title', __('Profile'))

@section('content')
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            {{ __("You're logged in!") }}

            <br>
            <br>

            <a href="{{ route('profile.edit') }}">
                {{ __('Update Password') }}
            </a>

        </div>
    </div>
@endsection
