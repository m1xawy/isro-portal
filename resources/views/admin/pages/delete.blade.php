@extends('admin.layouts.app')
@section('title', __('Delete Page'))

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Delete Page</h1>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.pages.destroy', $pages->id) }}">
            @csrf
            @method('DELETE')

            <div class="row mb-0">
                <div class="col-md-10 offset-md-2">
                    <button type="submit" class="btn btn-danger">{{ __('Yes, Delete') }}</button>
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')

@endpush
@push('scripts')

@endpush
