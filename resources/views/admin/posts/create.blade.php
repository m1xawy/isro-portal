@extends('admin.layouts.app')
@section('title', __('Home DashBoard'))

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Create New Blog</h1>
        </div>

        <form method="POST" action="{{ route('admin.news.store') }}">
            @csrf
            <div class="row mb-3">
                <label for="title" class="col-md-2 col-form-label text-md-end">{{ __('Title') }}</label>

                <div class="col-md-10">
                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>

                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="slug" class="col-md-2 col-form-label text-md-end">{{ __('Slug') }}</label>

                <div class="col-md-10">
                    <input id="slug" type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug') }}" required>

                    @error('slug')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="published_at" class="col-md-2 col-form-label text-md-end">{{ __('Published At') }}</label>

                <div class="col-md-10">
                    <input id="published_at" type="date" class="form-control @error('published_at') is-invalid @enderror" name="published_at" value="{{ old('published_at') }}" required>

                    @error('published_at')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="category" class="col-md-2 col-form-label text-md-end">{{ __('Gategory') }}</label>

                <div class="col-md-10">
                    <select class="form-select" name="category" aria-label="Default select example">
                        <option value="news">News</option>
                        <option value="event">Event</option>
                        <option value="update">Update</option>
                    </select>

                    @error('category')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="news_content" class="col-md-2 col-form-label text-md-end">{{ __('Content') }}</label>

                <div class="col-md-10">
                    <textarea id="news_content" rows="20" class="form-control" name="news_content" required></textarea>

                    @error('news_content')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-md-10 offset-md-2">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Create Blog') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.2.0/tinymce.min.js"></script>
    <script type="text/javascript">
        tinymce.init( {
            selector:      "textarea#news_content",
            width:         "100%",
            height:        400,
            plugins:       [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table directionality emoticons template paste"
            ],
            toolbar:       "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons fontsizeselect",
            fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
            style_formats: [
                {title: 'Bold text', inline: 'b'},
                {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                {title: 'Example 1', inline: 'span', classes: 'example1'},
                {title: 'Example 2', inline: 'span', classes: 'example2'},
                {title: 'Table styles'},
                {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
            ]

        } );
    </script>
@endpush
@push('scripts')

@endpush
