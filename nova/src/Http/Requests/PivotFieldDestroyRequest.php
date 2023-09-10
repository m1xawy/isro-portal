<?php

namespace Laravel\Nova\Http\Requests;

use Laravel\Nova\Fields\File;
use Laravel\Nova\Nova;

class PivotFieldDestroyRequest extends NovaRequest
{
    /**
     * Authorize that the user may attach resources of the given type.
     *
     * @return void
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function authorizeForAttachment()
    {
        if (! $this->newResourceWith($this->findModelOrFail())->authorizedToAttach(
            $this, $this->findRelatedModel()
        )) {
            abort(403);
        }
    }

    /**
     * Get the pivot model for the relationship.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findPivotModel()
    {
        $resource = $this->findResourceOrFail();

        abort_unless($resource->hasRelatableField($this, $this->viaRelationship), 404);

        return once(function () use ($resource) {
            return $this->findRelatedModel()->{
                $resource->model()->{$this->viaRelationship}()->getPivotAccessor()
            };
        });
    }

    /**
     * Find the related resource for the operation.
     *
     * @param  string|int|null  $resourceId
     * @return \Laravel\Nova\Resource<\Illuminate\Database\Eloquent\Model>
     */
    public function findRelatedResource($resourceId = null)
    {
        return Nova::newResourceFromModel(
            $this->findRelatedModel($resourceId)
        );
    }

    /**
     * Find the related model for the operation.
     *
     * @param  string|int|null  $resourceId
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findRelatedModel($resourceId = null)
    {
        $resource = $this->findResourceOrFail();

        abort_unless($resource->hasRelatableField($this, $this->viaRelationship), 404);

        $query = $resource->model()->{$this->viaRelationship}()
                        ->withoutGlobalScopes();

        if (! is_null($resourceId)) {
            return $query->lockForUpdate()->findOrFail($resourceId);
        }

        return once(function () use ($query) {
            return $query->lockForUpdate()->findOrFail($this->relatedResourceId);
        });
    }

    /**
     * Find the field being deleted or fail if it is not found.
     *
     * @return \Laravel\Nova\Fields\Field&\Laravel\Nova\Fields\File
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function findFieldOrFail()
    {
        return $this->findRelatedResource()->resolvePivotFields($this, $this->resource)
            ->whereInstanceOf(File::class)
            ->findFieldByAttribute($this->field, function () {
                abort(404);
            });
    }
}
