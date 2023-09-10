<?php

namespace Laravel\Nova\Fields\Filters;

use Carbon\CarbonImmutable;
use Laravel\Nova\Http\Requests\NovaRequest;

class DateTimeFilter extends DateFilter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'date-time-field';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        $value = collect($value)->transform(function ($value) {
            return ! empty($value) ? rescue(function () use ($value) {
                return CarbonImmutable::parse($value);
            }, null) : null;
        });

        if ($value->filter()->isNotEmpty()) {
            $this->field->applyFilter($request, $query, $value->all());
        }

        return $query;
    }
}
