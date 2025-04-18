@extends('admin.layouts.app')
@section('title', __('Dashboard'))

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard</h1>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <p>Total Accounts Registered</p>
                        <h2>{{ $userCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <p>Total In-game Characters</p>
                        <h2>{{ $charCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <p>Total Amount of Gold</p>
                        <h2>{{ number_format($totalGold , 0, ',', '.')}}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <p>Total Amount of Silk</p>
                        {{--<h2>{{ number_format($totalGold , 0, ',', '.')}}</h2>--}}
                        <h2>{{ $totalSilk }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
