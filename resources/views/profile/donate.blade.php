@extends('layouts.app')
@section('title', __('Donate'))

@section('content')
    <div class="container">
        @if ($error = Session::get('error'))
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endif

        <div class="list-group">
            @forelse($donationMethods as $method)
                <a href="{{ route('donations-method-index', ['method' => $method->method]) }}" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="{{ asset('/images/donations/' . $method->image) }}" alt="" width="" height="40" class="rounded-circle flex-shrink-0">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div>
                            <h6 class="mb-0">{{ $method->name }}</h6>
                            <p class="mb-0 opacity-75">{{ __('Currency:') }} {{ $method->currency }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="alert alert-danger" role="alert">
                    {{ __('No Methods Available!') }}
                </div>
            @endforelse
        </div>
    </div>
@endsection
