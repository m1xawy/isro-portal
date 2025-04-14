@php
    $db_count =  getOnlineCount();
    $max_player = config('constants.general.options.max_player');
    $fake_player = config('constants.general.options.fake_player');
    $online_player = $db_count+$fake_player;
    $progress = ceil($online_player*100/$max_player);
@endphp

<div class="card mb-4">
    <div class="card-body text-center">
        <p class="mb-0">{{ __('Server Time:') }} <span id="idTimerClock">{{ date('H:i:s') }}</span></p>
        <p>{{ __('Online Players:') }} {{ $online_player }} / {{ $max_player }}</p>

        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar w-{{ $progress }}"></div>
        </div>
    </div>
</div>
