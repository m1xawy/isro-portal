<?php

namespace App\Nova\Templates;

use Illuminate\Http\Request;
use Murdercode\TinymceEditor\TinymceEditor;
use Outl1ne\PageManager\Template;

class PageTemplate extends Template
{
    // Name displayed in CMS
    public function name(Request $request): string
    {
        return parent::name($request);
    }

    // Fields displayed in CMS
    public function fields(Request $request): array
    {
        return [
            TinymceEditor::make(__('Content'), 'content')
                ->rules(['required', 'min:20'])
                ->fullWidth()
                ->help(__('The content of the page.')),
        ];
    }

    // Resolve data for serialization
    public function resolve($page, $params): array
    {
        // Modify data as you please (ie turn ID-s into models)
        return $page->data ?? [];
    }

    // Optional suffix to the route (ie {blogPostName})
    public function pathSuffix(): string|null
    {
        return null;
    }
}
