@if(config('global.widgets.online_counter.enable'))
    <div class="card mb-4">
        <div class="card-body text-center">
            <p class="mb-0">{{ __('Server Time:') }} <span id="idTimerClock">{{ date('H:i:s') }}</span></p>
            <p>{{ __('Online Players:') }} {{ $online_counter+config('global.widgets.online_counter.fake_player') }} / {{ config('global.widgets.online_counter.max_player') }}</p>

            <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="{{ ceil(($online_counter+config('global.widgets.online_counter.fake_player'))*100/config('global.widgets.online_counter.max_player')) }}" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar w-{{ ceil(($online_counter+config('global.widgets.online_counter.fake_player'))*100/config('global.widgets.online_counter.max_player')) }}"></div>
            </div>
        </div>
    </div>
@endif
