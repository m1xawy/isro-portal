@extends('layouts.full')
@section('title', __('Global History'))

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">{{ __('Message') }}</th>
                                <th scope="col">{{ __('Character') }}</th>
                                <th scope="col">{{ __('Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $value)
                                <tr>
                                    <td>[{{ $value->Comment }}]</td>
                                    <td>
                                        @if(!empty($value->CharName))
                                            <a href="{{ route('ranking.character.view', ['name' => $value->CharName]) }}" class="text-decoration-none">{{ $value->CharName }}</a>
                                        @else
                                            <span>{{ __('NoName') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::make($value->EventTime)->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">{{ __('No Records Found!') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
