@extends('layouts.full')
@section('title', __('Global History'))

@section('content')
    <div class="container">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Message</th>
                        <th scope="col">Character</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($globalHistory))
                        @foreach($globalHistory as $value)
                        <tr>
                            <td>[{{ $value->Comment }}]</td>
                            <td>
                                @if(!empty($value->CharName))
                                    <a href="{{ route('ranking.character.view', ['name' => $value->CharName]) }}" class="text-decoration-none">{{ $value->CharName }}</a>
                                @else
                                    <span>NoName</span>
                                @endif
                            </td>
                            <td>{{ $value->EventTime }}</td>
                        </tr>
                        @endforeach
                    @else
                        <tr><td colspan="3" class="text-center">No records found~</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
