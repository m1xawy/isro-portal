@extends('layouts.full')
@section('title', __('Downloads'))

@section('content')
    <div class="space-y-6">
        <div class="lg:flex lg:flex-wrap space-x-6">
            @forelse($downloads as $download)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg md:w-1/4 p-4">
                    <div class="text-gray-900 dark:text-gray-100">
                        @if ( $download->icon )
                            <img class="object-contain object-center w-full lg:h-48 md:h-36" src="{{ Storage::url($download->icon) }}" alt="{{ $download->name }}">
                        @endif
                        <div class="p-6 text-center">
                            <h1 class="mb-2 text-2xl font-medium text-gray-900 dark:text-gray-100">{{ $download->name }}</h1>
                            <p class="mb-2 text-sm">{{ $download->desc }}</p>
                            <a href="{{ $download->url }}" target="_blank" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 cursor-pointer">Download</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg w-full">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        No Downloads available
                    </div>
                </div>
            @endforelse
        </div>

        <div class="text-gray-900 dark:text-gray-100 text-center mt-3">
            <h1>System Requirements</h1>
        </div>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3"></th>
                                <th scope="col" class="px-6 py-3">Minimum Requirements</th>
                                <th scope="col" class="px-6 py-3">Recommended Requirements</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row">CPU</th>
                                <td class="px-6 py-4">Pentium 3 800MHz or higher</td>
                                <td class="px-6 py-4">Intel i3 or higher</td>
                            </tr>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row">RAM</th>
                                <td class="px-6 py-4">2GB</td>
                                <td class="px-6 py-4">4GB</td>
                            </tr>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row">VGA</th>
                                <td class="px-6 py-4">3D speed over GeForce2 or ATI 9000</td>
                                <td class="px-6 py-4">3D speed over GeForce FX 5600 or ATI9500</td>
                            </tr>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row">SOUND</th>
                                <td class="px-6 py-4">DirectX 9.0c Compatibility card</td>
                                <td class="px-6 py-4">DirectX 9.0c Compatibility card</td>
                            </tr>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row">HDD</th>
                                <td class="px-6 py-4">5GB or higher(including swap and temporary file)</td>
                                <td class="px-6 py-4">8GB or higher(including swap and temporary file)</td>
                            </tr>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row">OS</th>
                                <td class="px-6 py-4">Windows 7</td>
                                <td class="px-6 py-4">Windows 10</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
