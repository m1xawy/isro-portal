@if (config('settings.widgets.top_guild.enable'))
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Top Guild') }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">{{ __('Rank') }}</th>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col">{{ __('Points') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @forelse($top_guild as $value)
                            <tr>
                                <td>
                                    @if($i <= 3)
                                        <img src="{{ asset(config('settings.ranking.top_icons')[$i]) }}" alt=""/>
                                    @else
                                        {{ $i }}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('ranking.guild.view', ['name' => $value->Name]) }}" class="text-decoration-none">{{ $value->Name }}</a>
                                </td>
                                <td>{{ $value->ItemPoints }}</td>
                            </tr>
                            @php $i++ @endphp
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
@endif
