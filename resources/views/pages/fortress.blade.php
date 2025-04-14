@extends('layouts.full')
@section('title', __('Fortress History'))

@section('content')
    <div class="container">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Fortress</th>
                        <th scope="col">Winner</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @php $const = config('constants.widgets.fortress_war.data'); @endphp
                    @forelse($fortressHistory as $value)
                        <tr>
                            <td>
                                <img src="{{ $const[$value->FortressID]['icon'] }}" alt="">
                                {{ $const[$value->FortressID]['name'] }}
                            </td>
                            <td>
                                @if(!empty($value->strDesc))
                                    <a href="{{ route('ranking.guild.view', ['name' => $value->strDesc]) }}" class="text-decoration-none">{{ $value->strDesc }}</a>
                                @else
                                    <span>NoName</span>
                                @endif
                            </td>
                            <td>{{ $value->EventTime }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center">No records found!</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
