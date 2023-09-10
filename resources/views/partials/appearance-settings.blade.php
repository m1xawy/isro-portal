<style>
    .bg-white {
        background-color: {{ nova_get_setting('color_boxes', '#ffffff') }};
    }
    .text-gray-600 {
        color: {{ nova_get_setting('color_paragraph', '#4b5563') }};
    }
    .text-gray-900 {
        color: {{ nova_get_setting('color_heading', '#111827') }};
    }

    :is(.dark .dark\:bg-gray-800) {
        background-color: {{ nova_get_setting('color_boxes', '#1f2937') }};
    }
    :is(.dark .dark\:bg-gray-700) {
        background-color: {{ nova_get_setting('color_dropdown', '#374151') }};
    }
    :is(.dark .dark\:text-gray-400) {
        color: {{ nova_get_setting('color_paragraph', '#9ca3af') }};
    }
    :is(.dark .dark\:text-gray-100) {
        color: {{ nova_get_setting('color_heading', '#f3f4f6') }};
    }
    :is(.dark .dark\:bg-gray-900) {
        background-color: {{ nova_get_setting('color_input', '#111827') }};
    }
    :is(.dark .dark\:hover\:bg-gray-800:hover) {
        background-color: {{ nova_get_setting('color_hover', '#1f2937') }};
    }

    body {
        background-color: {{ nova_get_setting('color_background', '#111827') }} !important;
    }
    body > header {
        background-image: url({{ asset(Storage::url(nova_get_setting('color_background_image', ''))) }}) !important;
    }
    body > nav {
        background-color: {{ nova_get_setting('color_navbar', '#1f2937') }} !important;
        border-color: {{ nova_get_setting('color_border', '#374151') }} !important;
    }
    body > footer {
        background-color: {{ nova_get_setting('color_footer', '#1f2937') }} !important;
    }
    a {
        color: {{ nova_get_setting('color_link', '#4b5563') }} !important;
    }
    a:hover {
        background-color: {{ nova_get_setting('color_hover', '#1f2937') }};
    }

    hr {
        border-color: {{ nova_get_setting('color_border', '#374151') }} !important;
    }
    p {
        color: {{ nova_get_setting('color_paragraph', '#9ca3af') }} !important;
    }
    h1, h2, h3, h4, h5, h6 {
        color: {{ nova_get_setting('color_heading', '#f3f4f6') }} !important;
    }
    form button {
        background-color: {{ nova_get_setting('color_background_button', '#1f2937') }} !important;
        color: {{ nova_get_setting('color_button', '#e5e7e') }} !important;
    }
    form input {
        background-color: {{ nova_get_setting('color_input', '#111827') }} !important;
        border-color: {{ nova_get_setting('color_border', '#374151') }} !important;
    }
</style>