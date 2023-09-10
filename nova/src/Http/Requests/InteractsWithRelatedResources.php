<?php

namespace Laravel\Nova\Http\Requests;

use Laravel\Nova\Nova;
use Laravel\Nova\Resource;

trait InteractsWithRelatedResources
{
    /**
     * Find the parent resource model instance for the request.
     *
     * @param  string|int|null  $resourceId
     * @return \Laravel\Nova\Resource
     */
    public function findParentResource($resourceId = null)
    {
        $resource = $this->viaResource();

        return new $resource($this->findParentModel($resourceId));
    }

    /**
     * Find the parent resource model instance for the request.
     *
     * @param  string|int|null  $resourceId
     * @return \Laravel\Nova\Resource<\Illuminate\Database\Eloquent\Model>
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findParentResourceOrFail($resourceId = null)
    {
        $resource = $this->viaResource();

        return new $resource($this->findParentModelOrFail($resourceId));
    }

    /**
     * Find the parent resource model instance for the request.
     *
     * @param  string|int|null  $resourceId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findParentModel($resourceId = null)
    {
        if (! $this->viaRelationship()) {
            return null;
        }

        return rescue(function () use ($resourceId) {
            return $this->findParentModelOrFail($resourceId);
        }, Nova::modelInstanceForKey($this->viaResource), false);
    }

    /**
     * Find the parent resource model instance for the request or abort.
     *
     * @param  string|int|null  $resourceId
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findParentModelOrFail($resourceId = null)
    {
        $query = Nova::modelInstanceForKey($this->viaResource)->newQueryWithoutScopes();

        if (! is_null($resourceId)) {
            return $query->whereKey($resourceId)->firstOrFail();
        }

        return once(function () use ($query) {
            return $query->findOrFail($this->viaResourceId);
        });
    }

    /**
     * Find the related resource instance for the request.
     *
     * @param  string|int|null  $resourceId
     * @return \Laravel\Nova\Resource
     */
    public function findRelatedResource($resourceId = null)
    {
        $resource = $this->relatedResource();

        return new $resource($this->findRelatedModel($resourceId));
    }

    /**
     * Find the related resource instance for the request or abort.
     *
     * @param  string|int|null  $resourceId
     * @return \Laravel\Nova\Resource<\Illuminate\Database\Eloquent\Model>
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findRelatedResourceOrFail($resourceId = null)
    {
        $resource = $this->relatedResource();

        return new $resource($this->findRelatedModelOrFail($resourceId));
    }

    /**
     * Find the related resource model instance for the request.
     *
     * @param  string|int|null  $resourceId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findRelatedModel($resourceId = null)
    {
        return rescue(function () use ($resourceId) {
            return $this->findRelatedModelOrFail($resourceId);
        }, Nova::modelInstanceForKey($this->relatedResource), false);
    }

    /**
     * Find the parent resource model instance for the request or abort.
     *
     * @param  string|int|null  $resourceId
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findRelatedModelOrFail($resourceId = null)
    {
        $query = Nova::modelInstanceForKey($this->relatedResource)->newQueryWithoutScopes();

        if (! is_null($resourceId)) {
            return $query->whereKey($resourceId)->firstOrFail();
        }

        return once(function () use ($query) {
            return $query->findOrFail($this->input($this->relatedResource));
        });
    }

    /**
     * Get the displayable pivot model name for a "via relationship" request.
     *
     * @return string
     */
    public function pivotName()
    {
        if (! $this->viaRelationship()) {
            return Resource::DEFAULT_PIVOT_NAME;
        }

        $resource = Nova::resourceInstanceForKey($this->viaResource);

        if ($name = $resource->pivotNameForField($this, $this->viaRelationship)) {
            return $name;
        }

        $parentResource = $this->findParentResource();

        $parent = $parentResource->model();

        return ($parent && $parentResource->hasRelatableField($this, $this->viaRelationship))
                    ? class_basename($parent->{$this->viaRelationship}()->getPivotClass())
                    : Resource::DEFAULT_PIVOT_NAME;
    }

    /**
     * Get the class name of the "related" resource being requested.
     *
     * @return class-string<\Laravel\Nova\Resource>
     */
    public function relatedResource()
    {
        return Nova::resourceForKey($this->relatedResource);
    }

    /**
     * Get a new instance of the "related" resource being requested.
     *
     * @return \Laravel\Nova\Resource<\Illuminate\Database\Eloquent\Model>
     */
    public function newRelatedResource()
    {
        $resource = $this->relatedResource();

        return new $resource($resource::newModel());
    }

    /**
     * Get the class name of the "via" resource being requested.
     *
     * @return class-string<\Laravel\Nova\Resource>
     */
    public function viaResource()
    {
        return Nova::resourceForKey($this->viaResource);
    }

    /**
     * Get a new instance of the "via" resource being requested.
     *
     * @return \Laravel\Nova\Resource<\Illuminate\Database\Eloquent\Model>
     */
    public function newViaResource()
    {
        $resource = $this->viaResource();

        return new $resource($resource::newModel());
    }

    /**
     * Determine if the request is via a relationship.
     *
     * @return bool
     */
    public function viaRelationship()
    {
        return $this->viaResource && $this->viaResourceId && $this->viaRelationship;
    }

    /**
     * Determine if this request is via a many-to-many relationship.
     *
     * @return bool
     */
    public function viaManyToMany()
    {
        return in_array(
            $this->relationshipType,
            ['belongsToMany', 'morphToMany']
        );
    }
}
