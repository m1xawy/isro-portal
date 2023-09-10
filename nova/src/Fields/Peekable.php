<?php

namespace Laravel\Nova\Fields;

use Laravel\Nova\Http\Requests\NovaRequest;

trait Peekable
{
    /**
     * Indicates if the related resource can be peeked at.
     *
     * @var (callable(\Laravel\Nova\Http\Requests\NovaRequest):(bool))|bool|null
     */
    public $peekable = true;

    /**
     * Specify if the related resource can be peeked at.
     *
     * @param  (callable(\Laravel\Nova\Http\Requests\NovaRequest):(bool))|bool  $callback
     * @return $this
     */
    public function peekable($callback = true)
    {
        $this->peekable = $callback;

        return $this;
    }

    /**
     * Prevent the user from peeking at the related resource.
     *
     * @return $this
     */
    public function noPeeking()
    {
        $this->peekable = false;

        return $this;
    }

    /**
     * Resolve whether the relation is able to be peeked at.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function isPeekable(NovaRequest $request)
    {
        if (is_callable($this->peekable)) {
            $this->peekable = call_user_func($this->peekable, $request);
        }

        return $this->peekable;
    }

    /**
     * Determine if the relation has fields that can be peeked at.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return bool
     */
    public function hasFieldsToPeekAt(NovaRequest $request)
    {
        if (! $request->isPresentationRequest() && ! $request->isResourcePreviewRequest()) {
            return false;
        }

        if (is_null($relatedResource = $this->relatedResource())) {
            return false;
        }

        return $relatedResource->peekableFieldsCount($request) > 0;
    }

    /**
     * Return the appropriate related Resource for the field.
     *
     * @return \Laravel\Nova\Resource|null
     */
    protected function relatedResource()
    {
        if ($this instanceof MorphTo) {
            return $this->morphToResource;
        }

        /** @phpstan-ignore-next-line */
        return $this->belongsToResource;
    }
}
