@extends('admin.layouts.app')
@section('title', __('Settings'))

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Settings</h1>

            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <form action="{{ route('admin.settings.clear-cache') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear all caches?')">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            Clear All Cache
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf

            <div class="row mb-3">
                <label for="site_title" class="col-md-2 col-form-label text-md-end">{{ __('Site Title') }}</label>

                <div class="col-md-10">
                    <input id="site_title" type="text" class="form-control @error('site_title') is-invalid @enderror" name="site_title" value="{{ $settings['site_title'] ?? '' }}" placeholder="" required>

                    @error('site_title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="site_desc" class="col-md-2 col-form-label text-md-end">{{ __('Site Description') }}</label>

                <div class="col-md-10">
                    <input id="site_desc" type="text" class="form-control @error('site_desc') is-invalid @enderror" name="site_desc" value="{{ $settings['site_desc'] ?? '' }}" placeholder="" required>

                    @error('site_desc')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="site_url" class="col-md-2 col-form-label text-md-end">{{ __('Site URL') }}</label>

                <div class="col-md-10">
                    <input id="site_url" type="text" class="form-control @error('site_url') is-invalid @enderror" name="site_url" value="{{ $settings['site_url'] ?? '' }}" placeholder="" required>

                    @error('site_url')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="site_favicon" class="col-md-2 col-form-label text-md-end">{{ __('Site Favicon') }}</label>

                <div class="col-md-10">
                    <input id="site_favicon" type="text" class="form-control @error('site_favicon') is-invalid @enderror" name="site_favicon" value="{{ $settings['site_favicon'] ?? '' }}" placeholder="" required>

                    @error('site_favicon')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="site_logo" class="col-md-2 col-form-label text-md-end">{{ __('Site Logo') }}</label>

                <div class="col-md-10">
                    <input id="site_logo" type="text" class="form-control @error('site_logo') is-invalid @enderror" name="site_logo" value="{{ $settings['site_logo'] ?? '' }}" placeholder="" required>

                    @error('site_logo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="dark_mode" class="col-md-2 col-form-label text-md-end">{{ __('Dark Mode') }}</label>

                <div class="col-md-10">
                    <select class="form-select" name="dark_mode" aria-label="Default select example">
                        <option value="switch" {{ config('settings.dark_mode') == 'switch' ? 'selected' : '' }}>Switch</option>
                        <option value="light" {{ config('settings.dark_mode') == 'light' ? 'selected' : '' }}>Light</option>
                        <option value="dark" {{ config('settings.dark_mode') == 'dark' ? 'selected' : '' }}>Dark</option>
                    </select>

                    @error('dark_mode')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="disable_register" class="col-md-2 col-form-label text-md-end">{{ __('Disable Register') }}</label>

                <div class="col-md-10">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="disable_register" value="{{ old('disable_register', config('settings.disable_register') == 1) ? '1' : '0' }}" id="disable_register" {{ config('settings.disable_register') == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="disable_register">
                            Disable
                        </label>
                    </div>

                    @error('disable_register')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-md-10 offset-md-2">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Save') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')

@endpush
@push('scripts')
    <script>
        const checkbox = document.getElementById('disable_register');

        checkbox.addEventListener('change', function () {
            checkbox.value = this.checked ? '1' : '0';
        });
    </script>
@endpush
