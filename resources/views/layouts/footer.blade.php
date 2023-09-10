<footer class="bg-white dark:bg-gray-800">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
            <div class="mb-6 md:mb-0">
                <a href="{{ nova_get_setting('server_url', config('app.url', '/')) }}" class="flex items-center">
                    <img src="{{ asset(Storage::url(nova_get_setting('server_logo', ''))) }}" class="w-40 mr-3" alt="{{ nova_get_setting('server_name', config('app.name', 'Laravel')) }}" />
                </a>
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
                        @if (count($backlinks))
                            @foreach($backlinks as $backlink)
                                <li>
                                    <a href="{{ $backlink->url }}" class="hover:underline">
                                        @if ( $backlink->icon )
                                            <img class="inline-block w-4" src="{{ Storage::url($backlink->icon) }}" alt="{{ $backlink->name }}">
                                        @endif
                                        {{ $backlink->name }}
                                    </a>
                                </li>
                            @endforeach
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
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <div class="sm:flex sm:items-center sm:justify-between">
            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a href="{{ nova_get_setting('server_url', config('app.url', '/')) }}" class="hover:underline">{{ nova_get_setting('server_name', config('app.name', 'Laravel')) }}</a>. All Rights Reserved. · Coded by <a class="link-default" href="https://mix-shop.tech/">m1xawy</a></span>
            <div class="socials flex mt-4 space-x-5 sm:justify-center sm:mt-0">
                <style>.socials a svg {width: 1rem; height: 1rem;}</style>
                @if (count($socials))
                    @foreach($socials as $social)
                        <a href="{{ $social->url }}" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                            {!! $social->icon !!}
                            <span class="sr-only">{{ $social->name }}</span>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</footer>
