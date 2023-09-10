<?php

namespace Laravel\Nova\Http\Controllers\Pages;

use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Laravel\Nova\Http\Requests\ResourceDetailRequest;
use Laravel\Nova\Http\Resources\DetailViewResource;
use Laravel\Nova\Menu\Breadcrumb;
use Laravel\Nova\Menu\Breadcrumbs;
use Laravel\Nova\Nova;

class ResourceDetailController extends Controller
{
    /**
     * Show Resource Detail page using Inertia.
     *
     * @param  \Laravel\Nova\Http\Requests\ResourceDetailRequest  $request
     * @return \Inertia\Response
     */
    public function __invoke(ResourceDetailRequest $request)
    {
        $resourceClass = $request->resource();

        return Inertia::render('Nova.Detail', [
            'breadcrumbs' => $this->breadcrumbs($request),
            'resourceName' => $resourceClass::uriKey(),
            'resourceId' => $request->resourceId,
        ]);
    }

    /**
     * Get breadcrumb menu for the page.
     *
     * @param  \Laravel\Nova\Http\Requests\ResourceDetailRequest  $request
     * @return \Laravel\Nova\Menu\Breadcrumbs
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    protected function breadcrumbs(ResourceDetailRequest $request)
    {
        $resource = DetailViewResource::make()->authorizedResourceForRequest($request);

        return Breadcrumbs::make([
            Breadcrumb::make(Nova::__('Resources')),
            Breadcrumb::resource($request->resource()),
            Breadcrumb::make(Nova::__(':resource Details: :title', [
                'resource' => $resource::singularLabel(),
                'title' => $resource->title(),
            ])),
        ]);
    }
}
