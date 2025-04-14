@extends('layouts.full')
@section('title', __('Unique Tracker'))

@section('content')
    <div class="container">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">{{ __('Unique') }}</th>
                        <th scope="col">{{ __('Dead Time') }}</th>
                        <th scope="col">{{ __('Killer') }}</th>
                        <th scope="col">{{ __('Area') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($uniques))
                        @foreach($uniques as $key => $value)
                            <tr>
                                <td>{{ $uniques_name[$value->Value] }}</td>
                                <td>{{ $value->EventTime }}</td>
                                <td>
                                    @if($value->RefObjID > 2000)
                                        <img src="{{ asset('images/european.png') }}" style="display:inline;vertical-align:text-top" alt=""/>
                                    @else
                                        <img src="{{ asset('images/chinese.png') }}" style="display:inline;vertical-align:text-top" alt=""/>
                                    @endif

                                    @if($value->CharName16)
                                        <a href="{{ route('ranking.character.view', ['name' => $value->CharName16]) }}" class="text-decoration-none">{{ $value->CharName16 }}</a>
                                    @else
                                        <span>{{ __('NoName') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @switch($value->AreaName)
                                        @case('Eu')
                                            {{ __('Constantinople') }}
                                            @break
                                        @case('Am')
                                            {{ __('Asia Minor') }}
                                            @break
                                        @default
                                            {{ $value->AreaName }}
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="4" class="text-center">{{ __('No Records Found!') }}</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
