@php
    $OnlineCount =  getOnlineCount();
    $MaxCount = config('constants.general.options.max_player');
    $progress = ceil($OnlineCount*100/$MaxCount);
@endphp

<div class="card mb-4">
    <div class="card-body text-center">
        <p class="mb-0">{{ __('Server Time:') }} <span id="idTimerClock">{{ date('H:i:s') }}</span></p>
        <p>{{ __('Online Players:') }} {{ $OnlineCount }} / {{ $MaxCount }}</p>

        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar w-{{ $progress }}"></div>
        </div>
    </div>
</div>
