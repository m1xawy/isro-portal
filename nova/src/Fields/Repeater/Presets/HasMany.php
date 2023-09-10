<?php

namespace Laravel\Nova\Fields\Repeater\Presets;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany as EloquentHasMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\FieldCollection;
use Laravel\Nova\Fields\Repeater\RepeatableCollection;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Support\Fluent;

class HasMany implements Preset
{
    /**
     * Save the field value to permanent storage.
     *
     * @param  string|null  $uniqueField
     * @return \Closure|void
     */
    public function set(
        NovaRequest $request,
        Model $model,
        string $attribute,
        RepeatableCollection $repeatables,
        mixed $uniqueField
    ) {
        return function () use ($repeatables, $uniqueField, $request, $attribute, $model) {
            $repeaterItems = collect($request->{$attribute});
            /** @var EloquentHasMany $relation */
            $relation = $model->{$attribute}();

            if (! $uniqueField) {
                $relation->delete();
            } else {
                $this->deleteMissingRelations($attribute, $model, $repeaterItems, $uniqueField);
            }

            $repeaterItems->transform(function ($item, $blockKey) use ($repeatables, $attribute, $request) {
                $block = $repeatables->findByKey($item['type']);
                $fields = FieldCollection::make($block->fields($request));
                $data = Fluent::make();

                $callbacks = $fields
                    ->withoutUnfillable()
                    ->withoutMissingValues()
                    ->map(function (Field $field) use ($request, $data, $attribute, $blockKey) {
                        return $field->fillInto($request, $data, $field->attribute, "{$attribute}.{$blockKey}.fields.{$field->attribute}");
                    })
                    ->filter(function ($callback) {
                        return is_callable($callback);
                    })->toBase();

                return [$data, $callbacks, $item];
            })->each(function ($tuple) use ($model, $relation, $uniqueField) {
                [$data, $callbacks, $row] = $tuple;

                if ($uniqueField) {
                    $this->upsertRelation($model, $data, $row, $uniqueField, $relation);
                } else {
                    $relation->forceCreate($data->getAttributes());
                }

                $callbacks->each->__invoke();
            });
        };
    }

    /**
     * Retrieve the value from storage and hydrate the field's value.
     *
     * @param  mixed  $model
     * @return \Illuminate\Support\Collection
     */
    public function get(NovaRequest $request, $model, string $attribute, RepeatableCollection $repeatables)
    {
        return RepeatableCollection::make($model->{$attribute})
            ->map(function ($block) use ($repeatables) {
                return $repeatables->newRepeatableByModel($block);
            });
    }

    /**
     * Delete missing relations.
     *
     * @param  string  $attribute
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  \Illuminate\Support\Collection  $repeaterItems
     * @param  mixed  $uniqueField
     * @return void
     */
    public function deleteMissingRelations(string $attribute, Model $model, Collection $repeaterItems, mixed $uniqueField): void
    {
        $model->{$attribute}()->delete($model->{$attribute}()->pluck('id')->except(
            $repeaterItems->map(function ($item) use ($uniqueField) {
                return $item['fields'][$uniqueField];
            })
        ));
    }

    /**
     * Upsert relation.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  \Laravel\Nova\Support\Fluent  $data
     * @param  array  $row
     * @param  mixed  $uniqueField
     * @param  \Illuminate\Database\Eloquent\Relations\HasMany  $relation
     * @return void
     */
    public function upsertRelation(Model $model, Fluent $data, array $row, mixed $uniqueField, EloquentHasMany $relation): void
    {
        $model->unguarded(function () use ($data, $row, $uniqueField, $relation) {
            $relation->updateOrCreate(
                [$uniqueField => $row['fields'][$uniqueField]],
                Arr::except($data->getAttributes(), $uniqueField)
            );
        });
    }
}
