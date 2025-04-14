@extends('layouts.guest')
@section('title', __('Confirm Password'))

@section('content')
    <div class="container my-5">
        <div class="mb-3">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-md-5 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Confirm') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
