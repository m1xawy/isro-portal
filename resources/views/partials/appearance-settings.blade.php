<style>
    .bg-white {
        background-color: {{ cache()->remember('color_boxes', 600, function() { return setting('color_boxes', '#ffffff'); }) }};
    }
    .text-gray-600 {
        color: {{ cache()->remember('color_paragraph', 600, function() { return setting('color_paragraph', '#4b5563'); }) }};
    }
    .text-gray-900 {
        color: {{ cache()->remember('color_heading', 600, function() { return setting('color_heading', '#4b5563'); }) }};
    }

    :is(.dark .dark\:bg-gray-800) {
        background-color: {{ cache()->remember('color_boxes', 600, function() { return setting('color_boxes', '#1f2937'); }) }};
    }
    :is(.dark .dark\:bg-gray-700) {
        background-color: {{ cache()->remember('color_dropdown', 600, function() { return setting('color_dropdown', '#374151'); }) }};
    }
    :is(.dark .dark\:text-gray-400) {
        color: {{ cache()->remember('color_paragraph', 600, function() { return setting('color_paragraph', '#9ca3af'); }) }};
    }
    :is(.dark .dark\:text-gray-100) {
        color: {{ cache()->remember('color_heading', 600, function() { return setting('color_heading', '#f3f4f6'); }) }};
    }
    :is(.dark .dark\:bg-gray-900) {
        background-color: {{ cache()->remember('color_input', 600, function() { return setting('color_input', '#111827'); }) }};
    }
    :is(.dark .dark\:hover\:bg-gray-800:hover) {
        background-color: {{ cache()->remember('color_hover', 600, function() { return setting('color_hover', '#1f2937'); }) }};
    }

    body {
        background-color: {{ cache()->remember('color_background', 600, function() { return setting('color_background', '#111827'); }) }} !important;
    }
    body > header {
        background-image: url({{ asset(Storage::url(cache()->remember('color_background_image', 600, function() { return setting('color_background_image', ''); }))) }}) !important;
    }
    body > nav {
        background-color: {{ cache()->remember('color_navbar', 600, function() { return setting('color_navbar', '#1f2937'); }) }} !important;
        border-color: {{ cache()->remember('color_border', 600, function() { return setting('color_border', '#374151'); }) }} !important;
    }
    body > footer {
        background-color: {{ cache()->remember('color_footer', 600, function() { return setting('color_footer', '#1f2937'); }) }} !important;
    }
    a {
        color: {{ cache()->remember('color_link', 600, function() { return setting('color_link', '#4b5563'); }) }} !important;
    }
    a:hover {
        background-color: {{ cache()->remember('color_hover', 600, function() { return setting('color_hover', '#1f2937'); }) }};
    }

    hr {
        border-color: {{ cache()->remember('color_border', 600, function() { return setting('color_border', '#374151'); }) }} !important;
    }
    p {
        color: {{ cache()->remember('color_paragraph', 600, function() { return setting('color_paragraph', '#9ca3af'); }) }} !important;
    }
    h1, h2, h3, h4, h5, h6 {
        color: {{ cache()->remember('color_heading', 600, function() { return setting('color_heading', '#f3f4f6'); }) }} !important;
    }
    form button {
        background-color: {{ cache()->remember('color_background_button', 600, function() { return setting('color_background_button', '#1f2937'); }) }} !important;
        color: {{ cache()->remember('color_button', 600, function() { return setting('color_button', '#e5e7e'); }) }} !important;
    }
    form input {
        background-color: {{ cache()->remember('color_input', 600, function() { return setting('color_input', '#111827'); }) }} !important;
        border-color: {{ cache()->remember('color_border', 600, function() { return setting('color_border', '#374151'); }) }} !important;
    }
</style>
