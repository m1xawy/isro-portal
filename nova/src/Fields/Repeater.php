<?php

namespace Laravel\Nova\Fields;

use Laravel\Nova\Fields\Repeater\Presets\HasMany;
use Laravel\Nova\Fields\Repeater\Presets\JSON;
use Laravel\Nova\Fields\Repeater\Presets\Preset;
use Laravel\Nova\Fields\Repeater\Repeatable;
use Laravel\Nova\Fields\Repeater\RepeatableCollection;
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * @phpstan-import-type TFieldValidationRules from \Laravel\Nova\Fields\Field
 */
class Repeater extends Field
{
    /**
     * The resource class for the repeater.
     */
    public string $resourceClass;

    /**
     * The resource name for the repeater.
     */
    public string $resourceName;

    /**
     * @var string The relationship for the repeater.
     */
    public string $relationship;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'repeater-field';

    /**
     * Indicates if the field label and form element should sit on top of each other.
     *
     * @var bool
     */
    public $stacked = false;

    /**
     * Indicates whether the field should use all available white-space.
     *
     * @var bool
     */
    public $fullWidth = false;

    /**
     * The repeatable types used for the Repeater.
     *
     * @var \Laravel\Nova\Fields\Repeater\RepeatableCollection
     */
    public $repeatables;

    /**
     * @var bool
     */
    public $sortable = true;

    /**
     * @var string|null
     */
    public $uniqueField;

    /**
     * The preset used for the field.
     */
    public Preset $preset;

    /**
     * Create a new field.
     *
     * @param  string  $name
     * @param  string|null  $attribute
     * @param  class-string<\Laravel\Nova\Resource>|null  $resource
     * @param  (callable(mixed, mixed, ?string):mixed)|null  $resolveCallback
     */
    public function __construct($name, $attribute = null, $resource = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->onlyOnForms();
        $this->repeatables = RepeatableCollection::make();

        $resource = $resource ?? ResourceRelationshipGuesser::guessResource($name);

        if ($resource) {
            $this->resourceClass = $resource;
            $this->resourceName = $resource::uriKey();
            $this->relationship = $this->attribute = $attribute ?? ResourceRelationshipGuesser::guessRelation($name);
        }
    }

    /**
     * Specify the callback to be executed to retrieve the pivot fields.
     *
     * @param  array<int, string>  $repeatables
     * @return $this
     */
    public function repeatables(array $repeatables)
    {
        foreach ($repeatables as $repeatable) {
            $this->repeatables->push($repeatable);
        }

        return $this;
    }

    /**
     * Set the preset used for the field.
     *
     * @return $this
     */
    public function preset(Preset $preset)
    {
        $this->preset = $preset;

        return $this;
    }

    /**
     * Use the JSON preset for the field.
     *
     * @return $this
     */
    public function asJson()
    {
        return $this->preset(new JSON);
    }

    /**
     * Use the HasMany preset for the field.
     *
     * @return $this
     */
    public function asHasMany()
    {
        return $this->preset(new HasMany);
    }

    /**
     * Return the preset instance for the field.
     *
     * @return \Laravel\Nova\Fields\Repeater\Presets\Preset
     */
    public function getPreset()
    {
        return $this->preset ?? new JSON;
    }

    /**
     * Resolve the given attribute from the given resource.
     *
     * @param  mixed  $resource
     * @param  string  $attribute
     * @return mixed
     */
    protected function resolveAttribute($resource, $attribute)
    {
        $request = app(NovaRequest::class);

        return $this->getPreset()->get($request, $resource, $attribute, $this->repeatables);
    }

    /**
     * Determine if the field collection contains an ID field.
     */
    protected function fieldsContainsIDField(FieldCollection $fields): bool
    {
        return $fields->contains(function (Field $field) {
            return $field instanceof ID && $field->attribute === $this->uniqueField
                || $field instanceof Hidden && $field->attribute === $this->uniqueField;
        });
    }

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param  string  $requestAttribute
     * @param  \Illuminate\Database\Eloquent\Model|\Laravel\Nova\Support\Fluent  $model
     * @param  string  $attribute
     * @return \Closure
     */
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        return $this->getPreset()->set($request, $model, $attribute, $this->repeatables, $this->uniqueField);
    }

    /**
     * Get the creation rules for this field.
     *
     * @return array<array-key, mixed>
     *
     * @phpstan-return array<string, TFieldValidationRules>
     */
    public function getCreationRules(NovaRequest $request)
    {
        return array_merge_recursive(parent::getCreationRules($request), $this->formatRules());
    }

    /**
     * Get the update rules for this field.
     *
     * @return array<array-key, mixed>
     *
     * @phpstan-return array<string, TFieldValidationRules>
     */
    public function getUpdateRules(NovaRequest $request)
    {
        return array_merge_recursive(parent::getUpdateRules($request), $this->formatRules());
    }

    /**
     * Format available rules.
     *
     * @return array<array-key, mixed>
     *
     * @phpstan-return array<string, TFieldValidationRules>
     */
    protected function formatRules()
    {
        $request = app(NovaRequest::class);

        if ($request->method() === 'GET') {
            return [];
        }

        return collect($request->{$this->validationKey()})
            ->map(function ($item) {
                return $this->repeatables->findByKey($item['type']);
            })
            ->flatMap(function (Repeatable $repeatable, $index) use ($request) {
                return FieldCollection::make($repeatable->fields($request))
                    ->mapWithKeys(function (Field $field) use ($index) {
                        return ["{$this->validationKey()}.{$index}.fields.{$field->attribute}" => $field->rules];
                    });
            })
            ->all();
    }

    /**
     * Set the unique database column to use when attempting upserts.
     *
     * @param  string|null  $key
     * @return $this
     */
    public function uniqueField($key)
    {
        $this->uniqueField = $key;

        return $this;
    }

    /**
     * Prepare the field for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return array_merge([
            'blocks' => $this->repeatables,
            'sortable' => $this->sortable,
        ], parent::jsonSerialize());
    }
}
