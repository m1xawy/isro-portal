@extends('layouts.full')
@section('title', __('Unique Tracker'))

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col">{{ __('Unique') }}</th>
                            <th scope="col">{{ __('Dead/Spawn Time') }}</th>
                            <th scope="col">{{ __('Killer') }}</th>
                            <th scope="col">{{ __('Area') }}</th>
                            <th scope="col">{{ __('Status') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($data as $key => $value)
                            <tr>
                                <td>
                                    <img src="{{ asset(config('settings.ranking.unique_icons')[1]) }}" alt=""/>
                                    {{ config('settings.ranking.unique_points')[$value->Value]['name'] }}
                                </td>
                                <td>{{ $value->EventTime }}</td>
                                <td>
                                    @if($value->CharName16 && $value['ValueCodeName128'] == 'KILL_UNIQUE_MONSTER')
                                        @if($value->RefObjID > 2000)
                                            <img src="{{ asset(config('settings.ranking.race')[1]['icon']) }}" width="16" height="16" alt=""/>
                                        @else
                                            <img src="{{ asset(config('settings.ranking.race')[0]['icon']) }}" width="16" height="16" alt=""/>
                                        @endif
                                        <a href="{{ route('ranking.character.view', ['name' => $value->CharName16]) }}" class="text-decoration-none">{{ $value->CharName16 }}</a>
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
                                <td>
                                    @if($value['ValueCodeName128'] == 'KILL_UNIQUE_MONSTER')
                                        <span class="text-danger">{{ __('Killed') }}</span>
                                    @elseif($value['ValueCodeName128'] == 'SPAWN_UNIQUE_MONSTER')
                                        <span class="text-success">{{ __('Spawned') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">{{ __('No Records Found!') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
