@extends('layouts.full')
@section('title', __('Ranking'))

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">
                    <div class="d-inline-block text-center my-4 mx-3">
                        @foreach(config('settings.ranking.menu') as $value)
                            @if($value['enable'])
                                <button class="btn btn-primary ranking-main-button rounded-0 me-2 mb-2" data-link="{{ route($value['route']) }}">{{ $value['name'] }}</button>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="col-md-12">
                    <div id="content-replace">
                        @include('ranking.ranking.player')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
