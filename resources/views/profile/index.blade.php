@extends('layouts.app')
@section('title', __('Profile'))

@section('content')
    <div class="container">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th scope="row">Username</th>
                <td>{{ Auth::user()->username }}</td>
            </tr>
            <tr>
                <th scope="row">Email</th>
                <td>{{ Auth::user()->email }}</td>
            </tr>
            <tr>
                <th scope="row">Premium Silk</th>
                <td>{{ Auth::user()->getJCash()->PremiumSilk }}</td>
            </tr>
            <tr>
                <th scope="row">Month Usage</th>
                <td>{{ Auth::user()->getJCash()->MonthUsage }}</td>
            </tr>
            <tr>
                <th scope="row">3Month Usage</th>
                <td>{{ Auth::user()->getJCash()->ThreeMonthUsage }}</td>
            </tr>
            <tr>
                <th scope="row">Silk</th>
                <td>{{ Auth::user()->getJCash()->Silk }}</td>
            </tr>
            <tr>
                <th scope="row">VIP</th>
                <td>
                    @if(Auth::user()->getVIPInfo() !== null && Auth::user()->getVIPInfo()->VIPUserType > 0)
                        <img src="{{ asset('images/ingame/viplevel_'.Auth::user()->getVIPInfo()->VIPLv.'.jpg') }}" alt="">
                        <span>{{ config('constants.viplevel.level')[Auth::user()->getVIPInfo()->VIPLv] }}</span>
                    @else
                        <span>None</span>
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
