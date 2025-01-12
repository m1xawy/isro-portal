@if (setting('server_fortress_widget_enable'))
    @php
        $fortresses = getFortress();
    @endphp

    <div class="server-info p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="max-w-xl">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Fortress War') }}</h2>

            @if (count($fortresses))
            <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($fortresses as $fortress)
                    @php
                        switch ($fortress->FortressID) {
                            case 1:
                                $fortressName = 'Jangan Fortress';
                                break;
                            case 3:
                                $fortressName = 'Hotan Fortress';
                                break;
                            case 4:
                                $fortressName = 'Constantinople Fortress';
                                break;
                            case 6:
                                $fortressName = 'Bandit Fortress';
                                break;
                            default:
                                $fortressName = null;
                                break;
                        }
                    @endphp

                <li class="py-3 sm:py-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img src="{{ asset('images/ingame/fort-' .lcfirst(str_replace(' Fortress', '', $fortressName)). '.png') }}" alt="">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                {{ $fortressName }}
                            </p>
                        </div>
                        <div class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 font-medium">
                            @php if($fortress->Name !== 'DummyGuild') : @endphp
                                <a href="{{ route('ranking.guild.view', ['name' => $fortress->Name]) }}">{{ $fortress->Name }}</a>
                            @php else : @endphp
                                <span>None</span>
                            @php endif; @endphp
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            @else
                <p class="text-gray-500 dark:text-gray-400 font-medium">No Fortress.</p>
            @endif
        </div>
    </div>
@endif
