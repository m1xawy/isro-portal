@extends('layouts.full')
@section('title', __('Unique Tracker'))

@section('content')
    <div class="container">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Unique</th>
                        <th scope="col">Dead Time</th>
                        <th scope="col">Killer</th>
                        <th scope="col">Area</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($uniques))
                        @foreach($uniques as $key => $value)
                            <tr>
                                <td>{{ $uniques_name[$value->Value] }}</td>
                                <td>{{ $value->EventTime }}</td>
                                <td>
                                    @php if($value->RefObjID > 2000) : @endphp
                                    <img src="{{ asset('images/ingame/european.png') }}" style="display:inline;vertical-align:text-top" alt=""/>
                                    @php else : @endphp
                                    <img src="{{ asset('images/ingame/chinese.png') }}" style="display:inline;vertical-align:text-top" alt=""/>
                                    @php endif; @endphp

                                    @if($value->CharName16)
                                        <a href="{{ route('ranking.character.view', ['name' => $value->CharName16]) }}" class="text-decoration-none">{{ $value->CharName16 }}</a>
                                    @else
                                        <span>NoName</span>
                                    @endif
                                </td>
                                <td>
                                    @switch($value->AreaName)
                                        @case('Eu')
                                            Constantinople
                                            @break
                                        @case('Am')
                                            Asia Minor
                                            @break
                                        @default
                                            {{ $value->AreaName }}
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="4" class="text-center">No records found!</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
