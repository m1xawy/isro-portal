@if (config('constants.widgets.server_info.enable'))
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Server Info') }}
        </div>
        <div class="card-body">
            @php $server_info = config('constants.widgets.server_info.data'); @endphp
            @if (!empty($server_info))
                <ul class="list-unstyled">
                    @foreach($server_info as $value)
                        <li>
                            <span>
                                {!! $value['icon'] !!}
                                {{ $value['name'] }}
                            </span>
                            <span class="float-end">{{ $value['value'] }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No server info available!</p>
            @endif
        </div>
    </div>
@endif
