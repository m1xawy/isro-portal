@if (config('settings.widgets.server_info.enable'))
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Server Info') }}
        </div>
        <div class="card-body">
            <ul class="list-unstyled">
                @foreach(config('settings.widgets.server_info.data') as $value)
                    <li>
                        <span>
                            {!! $value['icon'] !!}
                            {{ $value['name'] }}
                        </span>
                        <span class="float-end">{{ $value['value'] }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
