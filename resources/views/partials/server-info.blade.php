@php
    $server_info = json_decode(nova_get_setting('server_info'))
@endphp

@if (isset($server_info) &&  count($server_info))
    <div class="server-info p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="max-w-xl">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Server Information') }}</h2>

            <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($server_info as $info)
                <li class="py-3 sm:py-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <style>.server-info svg {width: 1rem;height: 1rem;}</style>
                            {!! $info->attributes->server_info_icon !!}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                {{ $info->attributes->server_info_title }}
                            </p>
                        </div>
                        <div class="inline-flex items-center text-sm font-medium text-gray-900 dark:text-white">
                            {{ $info->attributes->server_info_value }}
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>

        </div>
    </div>
@else
    <p class="text-gray-500 dark:text-gray-400 font-medium">No Server Info.</p>
@endif
