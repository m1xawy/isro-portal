@if (config('constants.server_info.enable'))
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Server Info') }}
        </div>
        <div class="card-body">
            @php $server_info = config('constants.server_info.data'); @endphp
            @if (!empty($server_info))
                <ul class="list-unstyled">
                    @foreach($server_info as $info)
                        <li>
                            <span>
                                {!! $info['icon'] !!}
                                {{ $info['name'] }}
                            </span>
                            <span class="float-end">{{ $info['value'] }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No Server Info.</p>
            @endif
        </div>
    </div>
@endif
