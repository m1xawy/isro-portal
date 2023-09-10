<?php

namespace Laravel\Nova\Fields;

use Laravel\Nova\Http\Requests\NovaRequest;

trait AssociatableRelation
{
    /**
     * The callback that should be run to associate relations.
     *
     * @var (callable(\Laravel\Nova\Http\Requests\NovaRequest, \Illuminate\Database\Eloquent\Builder):(\Illuminate\Database\Eloquent\Builder))|null
     */
    public $relatableQueryCallback;

    /**
     * Determines if the display values should be automatically sorted.
     *
     * @var (callable(\Laravel\Nova\Http\Requests\NovaRequest):(bool))|bool
     */
    public $reordersOnAssociatableCallback = true;

    /**
     * Determine if the display values should be automatically sorted when rendering associatable relation.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return bool
     */
    public function shouldReorderAssociatableValues(NovaRequest $request)
    {
        if (is_callable($this->reordersOnAssociatableCallback)) {
            return call_user_func($this->reordersOnAssociatableCallback, $request);
        }

        return $this->reordersOnAssociatableCallback;
    }

    /**
     * Determine reordering on associatables.
     *
     * @return $this
     */
    public function dontReorderAssociatables()
    {
        $this->reordersOnAssociatableCallback = false;

        return $this;
    }

    /**
     * Determine reordering on associatables.
     *
     * @param  (callable(\Laravel\Nova\Http\Requests\NovaRequest):bool)|bool  $value
     * @return $this
     */
    public function reorderAssociatables($value = true)
    {
        $this->reordersOnAssociatableCallback = $value;

        return $this;
    }

    /**
     * Determine the associate relations query.
     *
     * @param  (callable(\Laravel\Nova\Http\Requests\NovaRequest, \Illuminate\Database\Eloquent\Builder):(\Illuminate\Database\Eloquent\Builder))|null  $callback
     * @return $this
     */
    public function relatableQueryUsing($callback)
    {
        $this->relatableQueryCallback = $callback;

        return $this;
    }
}
