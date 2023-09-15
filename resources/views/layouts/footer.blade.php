@php
    $backlinks = json_decode(setting('backlinks'));
    $socials = json_decode(setting('socials'));
@endphp

<footer class="bg-white dark:bg-gray-800">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
            <div class="mb-6 md:mb-0">
                <a href="{{ setting('server_url', config('app.url')) }}" class="flex items-center">
                    @if (!empty(setting('server_logo')))
                        <img src="{{ asset(Storage::url(setting('server_logo', ''))) }}" class="w-40 mr-3" alt="{{ setting('server_name', config('app.name')) }}"/>
                    @else
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"/>
                    @endif
                </a>
                <p class="text-gray-500 dark:text-gray-400 font-medium mt-3 w-80">All images on this website belong to their respective owners.</p>
            </div>
            <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Resources</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li class="mb-4">
                            <a href="/" class="hover:underline">Home</a>
                        </li>
                        <li>
                            <a href="/register" class="hover:underline">Sign up</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Backlinks</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        @if (isset($backlinks) && count($backlinks))
                            @foreach($backlinks as $backlink)
                                <li>
                                    <a href="{{ $backlink->attributes->backlink_url }}" class="hover:underline">
                                        @if (isset($backlink->attributes->backlink_icon))
                                            <img class="inline-block w-4" src="{{ $backlink->attributes->backlink_icon }}" alt="{{ $backlink->attributes->backlink_name }}">
                                        @endif
                                        {{ $backlink->attributes->backlink_name }}
                                    </a>
                                </li>
                            @endforeach
                        @else
                            No Backinks.
                        @endif
                    </ul>
                </div>
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Legal</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li class="mb-4">
                            <a href="#" class="hover:underline">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="#" class="hover:underline">Terms &amp; Conditions</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8"/>
        <div class="sm:flex sm:items-center sm:justify-between">
            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a href="{{ setting('server_url', config('app.url')) }}" class="hover:underline">{{ setting('server_name', config('app.name')) }}</a>. All Rights Reserved. · Coded by <a class="link-default" href="https://mix-shop.tech/">m1xawy</a></span>
            <div class="socials flex mt-4 space-x-5 sm:justify-center sm:mt-0">
                <style>.socials a svg {width: 1rem;height: 1rem;}</style>
                @if (isset($socials) && count($socials))
                    @foreach($socials as $social)
                        <a href="{{ $social->attributes->social_url }}" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                            {!! $social->attributes->social_icon !!}
                            <span class="sr-only">{{ $social->attributes->social_name }}</span>
                        </a>
                    @endforeach
                @else
                    <p class="text-gray-500 dark:text-gray-400 font-medium">No Social links.</p>
                @endif
            </div>
        </div>
    </div>
</footer>
