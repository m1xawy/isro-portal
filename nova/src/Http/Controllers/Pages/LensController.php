<?php

namespace Laravel\Nova\Http\Controllers\Pages;

use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Http\Resources\LensViewResource;
use Laravel\Nova\Menu\Breadcrumb;
use Laravel\Nova\Menu\Breadcrumbs;
use Laravel\Nova\Nova;

class LensController extends Controller
{
    /**
     * Show Resource Lens page using Inertia.
     *
     * @param  \Laravel\Nova\Http\Requests\LensRequest  $request
     * @return \Inertia\Response
     */
    public function __invoke(LensRequest $request)
    {
        $lens = LensViewResource::make()->authorizedLensForRequest($request);

        return Inertia::render('Nova.Lens', [
            'breadcrumbs' => $this->breadcrumbs($request),
            'resourceName' => $request->route('resource'),
            'lens' => $lens->uriKey(),
            'searchable' => $lens::searchable(),
        ]);
    }

    /**
     * Get breadcrumb menu for the page.
     *
     * @param  \Laravel\Nova\Http\Requests\LensRequest  $request
     * @return \Laravel\Nova\Menu\Breadcrumbs
     */
    protected function breadcrumbs(LensRequest $request)
    {
        return Breadcrumbs::make([
            Breadcrumb::make(Nova::__('Resources')),
            Breadcrumb::resource($request->resource()),
            Breadcrumb::make($request->lens()->name()),
        ]);
    }
}
