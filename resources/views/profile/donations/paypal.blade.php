@extends('layouts.app')
@section('title', __('Paypal'))

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

        <div class="row mb-3 text-center">
            @forelse($paypal as $data)
                <div class="col-md-3">
                    <div class="card mb-4 rounded-3 shadow-sm">
                        <div class="card-header py-3">
                            <h4 class="my-0 fw-normal">{{ $data->name }}</h4>
                        </div>
                        <div class="card-body">
                            <p>{{ $data->description }}</p>
                            <a href="{{ route('donate-paypal', ['id' => $data->id]) }}" class="w-100 btn btn-lg btn-primary">Buy Now</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-danger" role="alert">
                    No packages available!
                </div>
            @endforelse
        </div>

        @if($invoices->count() > 0)
        <div class="row mb-3">
            <h4>You have pending payments!</h4>

            <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
                        @foreach($invoices as $data)
                            <tr>
                                <td>{{ $data->name }}<span>[{{ $data->created_at->diffForHumans() }}]</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
@endsection
