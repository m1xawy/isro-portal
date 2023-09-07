<div class="hidden sm:flex sm:items-center sm:ml-6">
    <x-dropdown align="right" width="48" class="hs-dropdown" data-hs-dropdown-placement="bottom-right" data-hs-dropdown-offset="30">
        <x-slot name="trigger">
            <a class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                <span class="ml-2">{{ language()->getName($code = 'default') }}</span>

                <div class="ml-1">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
            </a>
        </x-slot>

        <x-slot name="content" id="selectThemeDropdown">
            @foreach (language()->allowed() as $code => $name)
                <a href="{{ language()->back($code) }}" class="hs-default-mode-active:bg-gray-100 block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out">
                    <span class="ml-2">{{ $name }}</span>
                </a>
            @endforeach
        </x-slot>
    </x-dropdown>
</div>
