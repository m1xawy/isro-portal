@extends('layouts.app')
@section('title', __('MaxiCard'))

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12 text-center">
                        <a href="{{ route('donate-maxicard-buy') }}" class="btn btn-primary">{{ __('Buy Now') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row text-center">
            @forelse($maxicard as $data)
                <div class="col-md-3">
                    <div class="card mb-4 rounded-3 shadow-sm">
                        <div class="card-header py-3">
                            <h4 class="my-0 fw-normal">{{ $data->name }}</h4>
                        </div>
                        <div class="card-body">
                            <p>{{ $data->description }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-danger" role="alert">
                    {{ __('No Packages Available!') }}
                </div>
            @endforelse
        </div>
    </div>
@endsection
