<?php

namespace Laravel\Nova\Fields\Repeater\Presets;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\FieldCollection;
use Laravel\Nova\Fields\Repeater\RepeatableCollection;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Support\Fluent;

class JSON implements Preset
{
    /**
     * Save the field value to permanent storage.
     *
     * @param  string|null  $uniqueField
     * @return \Closure
     */
    public function set(
        NovaRequest $request,
        Model $model,
        string $attribute,
        RepeatableCollection $repeatables,
        mixed $uniqueField
    ) {
        $data = new Fluent();

        $fieldCallbacks = collect($request->{$attribute})
            ->map(function ($item, $blockKey) use ($model, $attribute, $data, $request, $repeatables) {
                $block = $repeatables->findByKey($item['type']);
                $fields = FieldCollection::make($block->fields($request));

                // For each field collection, return the callbacks and set the data on the model, and then return a function
                // that invokes all of the callbacks;
                $callbacks = $fields
                    ->withoutUnfillable()
                    ->withoutMissingValues()
                    ->map(function (Field $field) use ($request, $data, $attribute, $blockKey) {
                        return $field->fillInto($request, $data, $field->attribute, "{$attribute}.{$blockKey}.fields.{$field->attribute}");
                    })
                    ->filter(function ($callback) {
                        return is_callable($callback);
                    });

                // Set the block type on the data object
                $model->setAttribute("{$attribute}->{$blockKey}->type", $block->key());

                // Set the data on the model
                foreach ($data->getAttributes() as $k => $v) {
                    $model->setAttribute("{$attribute}->{$blockKey}->fields->{$k}", $v);
                }

                // Return a function that calls the callbacks from the fields
                return function () use ($callbacks) {
                    return $callbacks->each->__invoke();
                };
            });

        return function () use ($fieldCallbacks) {
            return collect($fieldCallbacks)->each->__invoke();
        };
    }

    /**
     * Retrieve the value from storage and hydrate the field's value.
     *
     * @return \Illuminate\Support\Collection
     */
    public function get(NovaRequest $request, Model $model, string $attribute, RepeatableCollection $repeatables)
    {
        return RepeatableCollection::make($model->{$attribute})
            ->map(function ($block) use ($repeatables) {
                return $repeatables->newRepeatableByKey($block['type'], $block['fields']);
            });
    }
}
