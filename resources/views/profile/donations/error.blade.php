@extends('layouts.app')
@section('title', __('Paypal'))

@section('content')
    <div class="container">
        <p class="font-bold">{{ __('Ups!') }}</p>
        <p class="text-sm">{{ __('Something went wrong, please try it again or write a ticket.') }}</p>

        @if ($message = Session::get('error'))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
        @endif

        <p>{{ __('You can try it again, we are logging each step you are doing.') }}</p>
        <a href="{{ route('profile.donate') }}" class="w-100 btn btn-lg btn-primary">{{ __('Go back') }}</a>
    </div>
@endsection
