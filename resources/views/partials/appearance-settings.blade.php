@php
    $color_boxes = cache()->remember('color_boxes', setting('cache_setting', 600), function() { return setting('color_boxes', '#1f2937'); });
    $color_paragraph = cache()->remember('color_paragraph', setting('cache_setting', 600), function() { return setting('color_paragraph', '#9ca3af'); });
    $color_heading = cache()->remember('color_heading', setting('cache_setting', 600), function() { return setting('color_heading', '#f3f4f6'); });
    $color_dropdown = cache()->remember('color_dropdown', setting('cache_setting', 600), function() { return setting('color_dropdown', '#374151'); });
    $color_input = cache()->remember('color_input', setting('cache_setting', 600), function() { return setting('color_input', '#111827'); });
    $color_hover = cache()->remember('color_hover', setting('cache_setting', 600), function() { return setting('color_hover', '#1f2937'); });
    $color_background = cache()->remember('color_background', setting('cache_setting', 600), function() { return setting('color_background', '#111827'); });
    $color_background_image = cache()->remember('color_background_image', setting('cache_setting', 600), function() { return setting('color_background_image', '#ffffff'); });
    $color_navbar = cache()->remember('color_navbar', setting('cache_setting', 600), function() { return setting('color_navbar', '#1f2937'); });
    $color_border = cache()->remember('color_border', setting('cache_setting', 600), function() { return setting('color_border', '#374151'); });
    $color_footer = cache()->remember('color_footer', setting('cache_setting', 600), function() { return setting('color_footer', '#1f2937'); });
    $color_link = cache()->remember('color_link', setting('cache_setting', 600), function() { return setting('color_link', '#4b5563'); });
    $color_background_button = cache()->remember('color_background_button', setting('cache_setting', 600), function() { return setting('color_background_button', '#1f2937'); });
    $color_button = cache()->remember('color_button', setting('cache_setting', 600), function() { return setting('color_button', '#e5e7e'); });
@endphp

<style>
    .bg-white {
        background-color: {{ $color_boxes }};
    }
    .text-gray-600 {
        color: {{ $color_paragraph }};
    }
    .text-gray-900 {
        color: {{ $color_heading }};
    }

    :is(.dark .dark\:bg-gray-800) {
        background-color: {{ $color_boxes }};
    }
    :is(.dark .dark\:bg-gray-700) {
        background-color: {{ $color_dropdown }};
    }
    :is(.dark .dark\:text-gray-400) {
        color: {{ $color_paragraph }};
    }
    :is(.dark .dark\:text-gray-100) {
        color: {{ $color_heading }};
    }
    :is(.dark .dark\:bg-gray-900) {
        background-color: {{ $color_input }};
    }
    :is(.dark .dark\:hover\:bg-gray-800:hover) {
        background-color: {{ $color_hover }};
    }

    body {
        background-color: {{ $color_background }} !important;
    }
    body > header {
        background-image: url({{ asset(Storage::url($color_background_image)) }}) !important;
    }
    body > nav {
        background-color: {{ $color_navbar }} !important;
        border-color: {{ $color_border }} !important;
    }
    body > footer {
        background-color: {{ $color_footer }} !important;
    }
    a {
        color: {{ $color_link }} !important;
    }
    a:hover {
        background-color: {{ $color_hover }};
    }

    hr {
        border-color: {{ $color_border }} !important;
    }
    p {
        color: {{ $color_paragraph }} !important;
    }
    h1, h2, h3, h4, h5, h6 {
        color: {{ $color_heading }} !important;
    }
    form button {
        background-color: {{ $color_background_button }} !important;
        color: {{ $color_button }} !important;
    }
    form input {
        background-color: {{ $color_input }} !important;
        border-color: {{ $color_border }} !important;
    }
</style>
