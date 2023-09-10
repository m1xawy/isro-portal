<?php

namespace Laravel\Nova\Fields;

use Illuminate\Support\Arr;
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * @phpstan-type TDependentResolver (callable(static, \Laravel\Nova\Http\Requests\NovaRequest, \Laravel\Nova\Fields\FormData):(void))|class-string
 */
class Dependent
{
    /**
     * The dependent context.
     *
     * @var array<int, string>
     */
    public $context = ['create', 'update'];

    /**
     * The dependent attributes.
     *
     * @var array<int, string|\Laravel\Nova\Fields\Field>
     */
    public $attributes = [];

    /**
     * The dependent resolver.
     *
     * @var callable
     *
     * @phpstan-var TDependentResolver
     */
    public $resolver;

    /**
     * The dependent resolved FormData.
     *
     * @var \Laravel\Nova\Fields\FormData|null
     */
    public $formData;

    /**
     * Create a new dependent object.
     *
     * @param  string|\Laravel\Nova\Fields\Field|array<int, string|\Laravel\Nova\Fields\Field>  $attributes
     * @param  callable  $resolver
     * @param  string|array<int, string>|null  $context
     *
     * @phpstan-param TDependentResolver $resolver
     */
    public function __construct($attributes, $resolver, $context = null)
    {
        $this->context = Arr::wrap($context ?? $this->context);

        $this->resolver = $resolver;

        $this->attributes = collect(Arr::wrap($attributes))->map(function ($item) {
            /** @var string|\Laravel\Nova\Fields\Field $item */
            if ($item instanceof MorphTo) {
                return [$item->attribute, "{$item->attribute}_type"];
            }

            return $item instanceof Field ? $item->attribute : $item;
        })->flatten()->all();
    }

    /**
     * Handle the dependencies for request.
     *
     * @param  \Laravel\Nova\Fields\Field  $field
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return $this
     */
    public function handle(Field $field, NovaRequest $request)
    {
        /** @var TDependentResolver|null $resolver */
        $resolver = (
            ($request->isCreateOrAttachRequest() && ! in_array('create', $this->context))
            || ($request->isUpdateOrUpdateAttachedRequest() && ! in_array('update', $this->context))
        ) ? null : $this->resolver;

        $this->formData = FormData::onlyFrom($request, array_merge($this->attributes, [$field->attribute]));

        if (is_string($resolver) && class_exists($resolver)) {
            $resolver = new $resolver();
        }

        if (is_callable($resolver)) {
            call_user_func($resolver, $field, $request, $this->formData);
        }

        return $this;
    }

    /**
     * Get depedent attributes.
     *
     * @return array<string, mixed>
     */
    public function getAttributes()
    {
        return collect($this->attributes)->mapWithKeys(function ($attribute) {
            return [$attribute => optional($this->formData)->get($attribute)];
        })->all();
    }
}
