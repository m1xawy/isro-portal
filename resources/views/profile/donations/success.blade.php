@extends('layouts.app')
@section('title', __('Paypal'))

@section('content')
    <div class="container">
        <p class="font-bold">{{ __('Done') }}</p>
        <p class="text-sm">{{ __('Your donation has been processed successfully, thanks!') }}</p>

        @if ($message = Session::get('successfully'))
            <div class="alert alert-success" role="alert">
                {{ __('You have just been credited '.$message.' Silk to your account. Have fun with it!') }}
            </div>
        @endif

        <a href="{{ route('home') }}" class="w-100 btn btn-lg btn-primary">{{ __('Go back to your Dashboard') }}</a>
    </div>
@endsection
