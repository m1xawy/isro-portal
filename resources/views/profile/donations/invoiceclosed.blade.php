@extends('layouts.app')
@section('title', __('Paypal'))

@section('content')
    <div class="container">
        <p class="font-bold">{{ __('Processed') }}</p>
        <p class="text-sm">{{ __('This donation was already processed, thanks!') }}</p>

        <p>{{ __('It seems that Paypal needs a little bit longer to send the answer to us, please wait a little bit, the transaction is being done right now.') }}</p>
        <a href="{{ route('profile.donate') }}" class="w-100 btn btn-lg btn-primary">{{ __('Go back') }}</a>
    </div>
@endsection
