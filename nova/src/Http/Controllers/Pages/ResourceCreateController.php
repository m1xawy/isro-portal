<?php

namespace Laravel\Nova\Http\Controllers\Pages;

use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Laravel\Nova\Http\Requests\ResourceCreateOrAttachRequest;
use Laravel\Nova\Menu\Breadcrumb;
use Laravel\Nova\Menu\Breadcrumbs;
use Laravel\Nova\Nova;

class ResourceCreateController extends Controller
{
    /**
     * Show Resource Create page using Inertia.
     *
     * @param  \Laravel\Nova\Http\Requests\ResourceCreateOrAttachRequest  $request
     * @return \Inertia\Response
     */
    public function __invoke(ResourceCreateOrAttachRequest $request)
    {
        $resourceClass = $request->resource();

        $resourceClass::authorizeToCreate($request);

        return Inertia::render('Nova.Create', [
            'breadcrumbs' => $this->breadcrumbs($request),
            'resourceName' => $resourceClass::uriKey(),
            'viaResource' => $request->query('viaResource') ?? '',
            'viaResourceId' => $request->query('viaResourceId') ?? '',
            'viaRelationship' => $request->query('viaRelationship') ?? '',
        ]);
    }

    /**
     * Get breadcrumb menu for the page.
     *
     * @param  \Laravel\Nova\Http\Requests\ResourceCreateOrAttachRequest  $request
     * @return \Laravel\Nova\Menu\Breadcrumbs
     */
    protected function breadcrumbs(ResourceCreateOrAttachRequest $request)
    {
        $resourceClass = $request->resource();

        return Breadcrumbs::make(
            collect([Breadcrumb::make(Nova::__('Resources'))])->when($request->viaRelationship(), function ($breadcrumbs) use ($request) {
                return $breadcrumbs->push(
                    Breadcrumb::resource($request->viaResource()),
                    Breadcrumb::resource($request->findParentResourceOrFail())
                );
            }, function ($breadcrumbs) use ($resourceClass) {
                return $breadcrumbs->push(Breadcrumb::resource($resourceClass));
            })->push(
                Breadcrumb::make(Nova::__('Create :resource', ['resource' => $resourceClass::singularLabel()]))
            )->all()
        );
    }
}
