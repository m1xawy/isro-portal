@php $sliders = config('constants.general.sliders'); @endphp
<div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
    @if (!empty($sliders) && count($sliders) > 1)
    <div class="carousel-indicators">
        @foreach($sliders as $key => $value)
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="{{ $key }}" @if($key == 0) class="active" @endif aria-current="true" aria-label="Slide {{ $key }}"></button>
        @endforeach
    </div>
    @endif
    <div class="carousel-inner">
        @if (!empty($sliders))
            @foreach($sliders as $key => $value)
                <div class="carousel-item @if($key == 0) active @endif">
                    <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice"><rect width="100%" height="100%" fill="var(--bs-secondary-color)"/></svg>

                    <div class="container">
                        <div class="carousel-caption">
                            <h1>{{ $value['title'] }}</h1>
                            <p class="opacity-75">{{ $value['desc'] }}</p>
                            <p><a class="btn btn-lg btn-primary" href="{{ $value['btn-url'] }}">{{ $value['btn-label'] }}</a></p>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
        <div class="carousel-item active">
            <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice"><rect width="100%" height="100%" fill="var(--bs-secondary-color)"/></svg>

            <div class="container">
                <div class="carousel-caption">
                    <h1>Example headline.</h1>
                    <p class="opacity-75">Some representative placeholder content for the first slide of the carousel.</p>
                    <p><a class="btn btn-lg btn-primary" href="#">Sign up today</a></p>
                </div>
            </div>
        </div>
        @endif
    </div>

    @if (!empty($sliders) && count($sliders) > 1)
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
