@php
    $sliders = cache()->remember('slider', setting('cache_widget', 600), function() { return json_decode(setting('slider')); });
@endphp

<div id="default-carousel" class="relative w-full" data-carousel="slide">
    <!-- Carousel wrapper -->
    <div class="relative h-96 overflow-hidden rounded-lg md:h-96">
        @if (!empty($sliders))
            @foreach($sliders as $slider)
                <!-- Item 1 -->
                <div class="hidden duration-1000 ease-in-out" data-carousel-item>
                    <section class="absolute block w-full bg-center bg-cover bg-no-repeat bg-gray-700 bg-blend-multiply" @if (isset($slider->attributes->slider_image)) style="background-image: url({{ $slider->attributes->slider_image }})" @endif>
                        <div class="px-4 mx-auto max-w-screen-xl text-left py-24 lg:py-24">
                            <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl dark:text-white mx-8">{{ $slider->attributes->slider_title }}</h1>
                            <p class="mb-8 text-lg font-normal text-gray-400 lg:text-xl dark:text-gray-400 mx-8">{{ $slider->attributes->slider_desc }}</p>
                            <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4 mx-8">
                                <a href="{{ $slider->attributes->slider_url }}" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 dark:focus:ring-indigo-900">
                                    Learn more
                                </a>
                            </div>
                        </div>
                    </section>
                </div>
            @endforeach
        @else
            <!-- Item 1 -->
            <div class="hidden duration-1000 ease-in-out" data-carousel-item>
                <section class="absolute block w-full bg-center bg-cover bg-no-repeat bg-gray-700 bg-blend-multiply">
                    <div class="px-4 mx-auto max-w-screen-xl text-left py-24 lg:py-24">
                        <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl dark:text-white mx-8">Title</h1>
                        <p class="mb-8 text-lg font-normal text-gray-400 lg:text-xl dark:text-gray-400 mx-8">Description</p>
                        <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4 mx-8">
                            <a href="#" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 dark:focus:ring-indigo-900">
                                Learn more
                            </a>
                        </div>
                    </div>
                </section>
            </div>
        @endif
    </div>
    @if (!empty($sliders) && count($sliders) > 1)
        <!-- Slider indicators -->
        <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
            @foreach($sliders as $key => $slider)
                <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide {{ $key }}" data-carousel-slide-to="{{ $key }}"></button>
            @endforeach
        </div>
        <!-- Slider controls -->
        <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    @endif
</div>

<script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
