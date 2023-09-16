@php
    $breadcrumb_enable = cache()->remember('breadcrumb_enable', setting('cache_setting', 600), function() { return setting('breadcrumb_enable'); });
    $color_background_image = cache()->remember('color_background_image', setting('cache_setting', 600), function() { return setting('color_background_image', ''); });
@endphp

@if ($breadcrumb_enable === 1)
    <header
        class="bg-gray-600 dark:bg-gray-800 shadow relative block w-full bg-center bg-cover bg-fixed bg-no-repeat bg-blend-multiply"
        style="background-image: url({{ asset(Storage::url($color_background_image)) }})">
        <div class="max-w-7xl mx-auto py-14 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-white dark:text-white leading-tight mx-8">
                @yield('title')
            </h2>

            <nav class="flex mx-8 my-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ url('/') }}"
                           class="inline-flex items-center text-sm font-medium text-gray-400 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="#"
                               class="ml-1 text-sm font-medium text-gray-400 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">@yield('title')</a>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </header>
@endif
