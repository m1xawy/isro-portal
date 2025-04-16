@extends('layouts.app')
@section('title', __('MaxiCard'))

@section('content')
    <div class="container">
        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
        @endif
        @if ($error = Session::get('error'))
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endif
        @if ($message = Session::get('message'))
            <div class="alert alert-primary" role="alert">
                {{ $message }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <form method="post" action="{{route('donate-maxicard-buy-post')}}">
                    @csrf

                    <div class="row mb-3">
                        <label for="code" class="col-md-4 col-form-label text-md-end">{{ __('E-Pin Code') }}</label>

                        <div class="col-md-6">
                            <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" required>

                            @error('code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('E-Pin Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="text" class="form-control @error('password') is-invalid @enderror" name="password" required>

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
