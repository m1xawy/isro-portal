<div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
    @if (count(config('settings.general.sliders')) > 1)
    <div class="carousel-indicators">
        @foreach(config('settings.general.sliders') as $key => $value)
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="{{ $key }}" @if($key == 0) class="active" @endif aria-current="true" aria-label="Slide {{ $key }}"></button>
        @endforeach
    </div>
    @endif
    <div class="carousel-inner">
        @foreach(config('settings.general.sliders') as $key => $value)
            <div class="carousel-item @if($key == 0) active @endif" style="background-image: url({{ $value['image'] }}) !important; background-repeat: no-repeat; background-size: cover; background-position: center;">

                <div class="container">
                    <div class="carousel-caption" style="bottom: 8rem;">
                        <h1 style="color: {{ $value['title_color'] }};">{{ $value['title'] }}</h1>
                        <p class="opacity-75" style="color: {{ $value['desc_color'] }};">{{ $value['desc'] }}</p>
                        <p><a class="btn btn-lg btn-primary" href="{{ $value['btn-url'] }}">{{ $value['btn-label'] }}</a></p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if (count(config('settings.general.sliders')) > 1)
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
    @endif
</div>
