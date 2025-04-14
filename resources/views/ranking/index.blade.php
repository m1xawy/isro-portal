@extends('layouts.full')
@section('title', __('Ranking'))

@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="d-flex mb-4">
                <button class="btn btn-primary ranking-main-button mx-2" data-link="{{ route('ranking.player') }}">{{ __('Player Ranking') }}</button>
                <button class="btn btn-primary ranking-main-button mx-2" data-link="{{ route('ranking.guild') }}">{{ __('Guild Ranking') }}</button>
                <button class="btn btn-primary ranking-main-button mx-2" data-link="{{ route('ranking.job') }}">{{ __('Job Ranking') }}</button>
                <button class="btn btn-primary ranking-main-button mx-2" data-link="{{ route('ranking.honor') }}">{{ __('Honor Ranking') }}</button>
                <button class="btn btn-primary ranking-main-button mx-2" data-link="{{ route('ranking.unique') }}">{{ __('Unique Ranking') }}</button>
                <button class="btn btn-primary ranking-main-button mx-2" data-link="{{ route('ranking.unique.monthly') }}">{{ __('Unique Ranking (Monthly)') }}</button>
                <button class="btn btn-primary ranking-main-button mx-2" data-link="{{ route('ranking.fortress.player') }}">{{ __('Fortress War (Player)') }}</button>
                <button class="btn btn-primary ranking-main-button mx-2" data-link="{{ route('ranking.fortress.guild') }}">{{ __('Fortress War (Guild)') }}</button>
            </div>
        </div>

        <div class="col-md-12">
            <div id="content-replace">
                @include('ranking.ranking.player')
            </div>
        </div>
    </div>
@endsection
