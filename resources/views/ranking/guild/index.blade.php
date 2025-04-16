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
                                        <img src="/ranking/guild-crest/{{ $guilds->Icon }}" alt="" width="32" height="32">
                                        {{ $guilds->Name }}
                                    </h2>
                                    <p class="m-0">Foundation Date: <span class="">{{ date('d-m-Y', strtotime($guilds->FoundationDate)) }}</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mt-2 justify-content-end text-center">
                                <div class="col-md-3">
                                    <ul class="list-unstyled mt-3">
                                        <li class="mb-2"><h4>{{ $guilds->Leader }}</h4></li>
                                        <li class="mb-2">Leader</li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <ul class="list-unstyled mt-3">
                                        <li class="mb-2"><h4>{{ $guilds->ItemPoints }}</h4></li>
                                        <li class="mb-2">Item Points</li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <ul class="list-unstyled mt-3">
                                        <li class="mb-2"><h4>{{ $guilds->Lvl }}</h4></li>
                                        <li class="mb-2">Level</li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <ul class="list-unstyled mt-3">
                                        <li class="mb-2"><h4>{{ $guilds->Members }}</h4></li>
                                        <li class="mb-2">Members</li>
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
