@extends('admin.layouts.app')
@section('title', __('Home DashBoard'))

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Create News</h1>
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
                <label for="content" class="col-md-2 col-form-label text-md-end">{{ __('Content') }}</label>

                <div class="col-md-10">
                    <textarea id="editor" rows="10" class="form-control" name="news_content"></textarea>

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
                        {{ __('Create News') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.css">
    <style>.ck-editor__editable_inline { height:400px; }</style>
@endpush
@push('scripts')
    <script type="importmap">
        {
            "imports": {
                "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.js",
                "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.2.0/"
            }
        }
    </script>

    <script type="module">
        import {
            ClassicEditor,
            AccessibilityHelp,
            Alignment,
            Autoformat,
            AutoImage,
            AutoLink,
            Autosave,
            BlockQuote,
            Bold,
            CloudServices,
            Code,
            CodeBlock,
            Essentials,
            FindAndReplace,
            FontBackgroundColor,
            FontColor,
            FontFamily,
            FontSize,
            FullPage,
            GeneralHtmlSupport,
            Heading,
            Highlight,
            HorizontalLine,
            HtmlComment,
            HtmlEmbed,
            ImageBlock,
            ImageCaption,
            ImageInline,
            ImageInsertViaUrl,
            ImageResize,
            ImageStyle,
            ImageTextAlternative,
            ImageToolbar,
            ImageUpload,
            Indent,
            IndentBlock,
            Italic,
            Link,
            LinkImage,
            List,
            ListProperties,
            PageBreak,
            Paragraph,
            PasteFromOffice,
            RemoveFormat,
            SelectAll,
            ShowBlocks,
            SourceEditing,
            SpecialCharacters,
            SpecialCharactersArrows,
            SpecialCharactersCurrency,
            SpecialCharactersEssentials,
            SpecialCharactersLatin,
            SpecialCharactersMathematical,
            SpecialCharactersText,
            Strikethrough,
            Style,
            Subscript,
            Superscript,
            Table,
            TableCaption,
            TableCellProperties,
            TableColumnResize,
            TableProperties,
            TableToolbar,
            TextTransformation,
            Underline,
            Undo
        } from 'ckeditor5';

        import translations from 'ckeditor5/translations/en.js';

        const editorConfig = {
            toolbar: {
                items: [
                    'undo',
                    'redo',
                    '|',
                    'sourceEditing',
                    'showBlocks',
                    '|',
                    'heading',
                    'style',
                    '|',
                    'fontSize',
                    'fontFamily',
                    'fontColor',
                    'fontBackgroundColor',
                    '|',
                    'bold',
                    'italic',
                    'underline',
                    '|',
                    'link',
                    'insertTable',
                    'highlight',
                    'blockQuote',
                    'codeBlock',
                    '|',
                    'alignment',
                    '|',
                    'bulletedList',
                    'numberedList',
                    'outdent',
                    'indent'
                ],
                shouldNotGroupWhenFull: true
            },
            plugins: [
                AccessibilityHelp,
                Alignment,
                Autoformat,
                AutoImage,
                AutoLink,
                Autosave,
                BlockQuote,
                Bold,
                CloudServices,
                Code,
                CodeBlock,
                Essentials,
                FindAndReplace,
                FontBackgroundColor,
                FontColor,
                FontFamily,
                FontSize,
                FullPage,
                GeneralHtmlSupport,
                Heading,
                Highlight,
                HorizontalLine,
                HtmlComment,
                HtmlEmbed,
                ImageBlock,
                ImageCaption,
                ImageInline,
                ImageInsertViaUrl,
                ImageResize,
                ImageStyle,
                ImageTextAlternative,
                ImageToolbar,
                ImageUpload,
                Indent,
                IndentBlock,
                Italic,
                Link,
                LinkImage,
                List,
                ListProperties,
                PageBreak,
                Paragraph,
                PasteFromOffice,
                RemoveFormat,
                SelectAll,
                ShowBlocks,
                SourceEditing,
                SpecialCharacters,
                SpecialCharactersArrows,
                SpecialCharactersCurrency,
                SpecialCharactersEssentials,
                SpecialCharactersLatin,
                SpecialCharactersMathematical,
                SpecialCharactersText,
                Strikethrough,
                Style,
                Subscript,
                Superscript,
                Table,
                TableCaption,
                TableCellProperties,
                TableColumnResize,
                TableProperties,
                TableToolbar,
                TextTransformation,
                Underline,
                Undo
            ],
            fontFamily: {
                supportAllValues: true
            },
            fontSize: {
                options: [10, 12, 14, 'default', 18, 20, 22],
                supportAllValues: true
            },
            heading: {
                options: [
                    {
                        model: 'paragraph',
                        title: 'Paragraph',
                        class: 'ck-heading_paragraph'
                    },
                    {
                        model: 'heading1',
                        view: 'h1',
                        title: 'Heading 1',
                        class: 'ck-heading_heading1'
                    },
                    {
                        model: 'heading2',
                        view: 'h2',
                        title: 'Heading 2',
                        class: 'ck-heading_heading2'
                    },
                    {
                        model: 'heading3',
                        view: 'h3',
                        title: 'Heading 3',
                        class: 'ck-heading_heading3'
                    },
                    {
                        model: 'heading4',
                        view: 'h4',
                        title: 'Heading 4',
                        class: 'ck-heading_heading4'
                    },
                    {
                        model: 'heading5',
                        view: 'h5',
                        title: 'Heading 5',
                        class: 'ck-heading_heading5'
                    },
                    {
                        model: 'heading6',
                        view: 'h6',
                        title: 'Heading 6',
                        class: 'ck-heading_heading6'
                    }
                ]
            },
            htmlSupport: {
                allow: [
                    {
                        name: /^.*$/,
                        styles: true,
                        attributes: true,
                        classes: true
                    }
                ]
            },
            image: {
                toolbar: [
                    'toggleImageCaption',
                    'imageTextAlternative',
                    '|',
                    'imageStyle:inline',
                    'imageStyle:wrapText',
                    'imageStyle:breakText',
                    '|',
                    'resizeImage'
                ]
            },
            initialData:
                '',
            language: 'en',
            link: {
                addTargetToExternalLinks: true,
                defaultProtocol: 'https://',
                decorators: {
                    toggleDownloadable: {
                        mode: 'manual',
                        label: 'Downloadable',
                        attributes: {
                            download: 'file'
                        }
                    }
                }
            },
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            },
            menuBar: {
                isVisible: true
            },
            placeholder: 'Type or paste your content here!',
            style: {
                definitions: [
                    {
                        name: 'Article category',
                        element: 'h3',
                        classes: ['category']
                    },
                    {
                        name: 'Title',
                        element: 'h2',
                        classes: ['document-title']
                    },
                    {
                        name: 'Subtitle',
                        element: 'h3',
                        classes: ['document-subtitle']
                    },
                    {
                        name: 'Info box',
                        element: 'p',
                        classes: ['info-box']
                    },
                    {
                        name: 'Side quote',
                        element: 'blockquote',
                        classes: ['side-quote']
                    },
                    {
                        name: 'Marker',
                        element: 'span',
                        classes: ['marker']
                    },
                    {
                        name: 'Spoiler',
                        element: 'span',
                        classes: ['spoiler']
                    },
                    {
                        name: 'Code (dark)',
                        element: 'pre',
                        classes: ['fancy-code', 'fancy-code-dark']
                    },
                    {
                        name: 'Code (bright)',
                        element: 'pre',
                        classes: ['fancy-code', 'fancy-code-bright']
                    }
                ]
            },
            table: {
                contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
            },
            translations: [translations],

        };

        ClassicEditor.create(document.querySelector('#editor'), editorConfig);
    </script>
@endpush
