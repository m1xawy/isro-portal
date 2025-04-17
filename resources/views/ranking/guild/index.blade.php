@extends('layouts.full')
@section('title', __('Ranking'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="card mb-4 p-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="mt-3">
                                    <h2>
                                        @if(isset($data->CrestIcon))
                                        <img src="/ranking/guild-crest/{{ $data->CrestIcon }}" alt="" width="32" height="32">
                                        @endif
                                        {{ $data->Name }}
                                    </h2>
                                    <p class="m-0">{{ __('Foundation Date:') }} <span class="">{{ date('d-m-Y', strtotime($data->FoundationDate)) }}</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mt-2 justify-content-end text-center">
                                <div class="col-md-3">
                                    <ul class="list-unstyled mt-3">
                                        <li class="mb-2"><h4>{{ $data->LeaderName }}</h4></li>
                                        <li class="mb-2">{{ __('Leader') }}</li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <ul class="list-unstyled mt-3">
                                        <li class="mb-2"><h4>{{ $data->ItemPoints }}</h4></li>
                                        <li class="mb-2">{{ __('Item Points') }}</li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <ul class="list-unstyled mt-3">
                                        <li class="mb-2"><h4>{{ $data->Lvl }}</h4></li>
                                        <li class="mb-2">{{ __('Level') }}</li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <ul class="list-unstyled mt-3">
                                        <li class="mb-2"><h4>{{ $data->TotalMember }}</h4></li>
                                        <li class="mb-2">{{ __('Members') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('ranking.guild.partials.guild-members')
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card mb-4">
                <div class="card-body">
                    @include('ranking.guild.partials.guild-alliances')
                </div>
            </div>
        </div>
    </div>
@endsection
