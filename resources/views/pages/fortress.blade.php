@extends('layouts.full')
@section('title', __('Fortress History'))

@section('content')
    <div class="container">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">{{ __('Fortress') }}</th>
                        <th scope="col">{{ __('Winner') }}</th>
                        <th scope="col">{{ __('Date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $value)
                        <tr>
                            <td>
                                <img src="{{ config('constants.widgets.fortress_war.data')[$value->FortressID]['icon'] }}" alt="">
                                {{ config('constants.widgets.fortress_war.data')[$value->FortressID]['name'] }}
                            </td>
                            <td>
                                @if(!empty($value->strDesc))
                                    <a href="{{ route('ranking.guild.view', ['name' => $value->strDesc]) }}" class="text-decoration-none">{{ $value->strDesc }}</a>
                                @else
                                    <span>{{ __('NoName') }}</span>
                                @endif
                            </td>
                            <td>{{ $value->EventTime }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center">{{ __('No Records Found!') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
