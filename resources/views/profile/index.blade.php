@extends('layouts.app')
@section('title', __('Profile'))

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th scope="row">{{ __('Username') }}</th>
                            <td>{{ Auth::user()->username }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('Email') }}</th>
                            <td>{{ Auth::user()->email }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('Premium Silk') }}</th>
                            <td>{{ Auth::user()->getJCash()->PremiumSilk }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('Month Usage') }}</th>
                            <td>{{ Auth::user()->getJCash()->MonthUsage }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('3Month Usage') }}</th>
                            <td>{{ Auth::user()->getJCash()->ThreeMonthUsage }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('Silk') }}</th>
                            <td>{{ Auth::user()->getJCash()->Silk }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('VIP') }}</th>
                            <td>
                                @if(Auth::user()->getVIPInfo() !== null && Auth::user()->getVIPInfo()->VIPUserType > 0)
                                    <img src="{{ asset('images/ingame/viplevel_'.Auth::user()->getVIPInfo()->VIPLv.'.jpg') }}" alt="">
                                    <span>{{ config('global.ranking.vip_level.level')[Auth::user()->getVIPInfo()->VIPLv] }}</span>
                                @else
                                    <span>{{ __('None') }}</span>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
