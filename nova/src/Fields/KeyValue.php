<?php

namespace Laravel\Nova\Fields;

use Illuminate\Support\Str;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;

class KeyValue extends Field
{
    use SupportsDependentFields;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'key-value-field';

    public function resolve($resource, $attribute = null)
    {
        parent::resolve($resource, $attribute);

        if ($this->value === '{}') {
            $this->value = null;
        }
    }

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    /**
     * The label that should be used for the key heading.
     *
     * @var string|null
     */
    public $keyLabel;

    /**
     * The label that should be used for the value heading.
     *
     * @var string|null
     */
    public $valueLabel;

    /**
     * The label that should be used for the "add row" button.
     *
     * @var string|null
     */
    public $actionText;

    /**
     * The callback used to determine if the keys are readonly.
     *
     * @var (callable(\Laravel\Nova\Http\Requests\NovaRequest):(bool))|bool|null
     */
    public $readonlyKeysCallback;

    /**
     * Determine if new rows are able to be added.
     *
     * @var bool
     */
    public $canAddRow = true;

    /**
     * Determine if rows are able to be deleted.
     *
     * @var bool
     */
    public $canDeleteRow = true;

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  string  $requestAttribute
     * @param  \Illuminate\Database\Eloquent\Model|\Laravel\Nova\Support\Fluent  $model
     * @param  string  $attribute
     * @return void
     */
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        if ($request->exists($requestAttribute)) {
            // The value for KeyValue fields are serialized on the front-end using `JSON.stringify`,
            // so we need to convert it to an associative array before saving it to the database.
            $this->fillModelWithData($model, json_decode($request[$requestAttribute], true), $attribute);
        }
    }

    /**
     * Fill the model's attribute with data.
     *
     * @param  \Illuminate\Database\Eloquent\Model|\Laravel\Nova\Support\Fluent  $model
     * @param  mixed  $value
     * @param  string  $attribute
     * @return void
     */
    public function fillModelWithData(mixed $model, mixed $value, string $attribute)
    {
        $model->forceFill([Str::replace('.', '->', $attribute) => $value]);
    }

    /**
     * The label that should be used for the key table heading.
     *
     * @param  string  $label
     * @return $this
     */
    public function keyLabel($label)
    {
        $this->keyLabel = $label;

        return $this;
    }

    /**
     * The label that should be used for the value table heading.
     *
     * @param  string  $label
     * @return $this
     */
    public function valueLabel($label)
    {
        $this->valueLabel = $label;

        return $this;
    }

    /**
     * The label that should be used for the add row button.
     *
     * @param  string  $label
     * @return $this
     */
    public function actionText($label)
    {
        $this->actionText = $label;

        return $this;
    }

    /**
     * Set the callback used to determine if the keys are readonly.
     *
     * @param  (callable(\Laravel\Nova\Http\Requests\NovaRequest):(bool))|bool  $callback
     * @return $this
     */
    public function disableEditingKeys($callback = true)
    {
        $this->readonlyKeysCallback = $callback;

        return $this;
    }

    /**
     * Determine if the keys are readonly.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return bool
     */
    public function readonlyKeys(NovaRequest $request)
    {
        return with($this->readonlyKeysCallback, function ($callback) use ($request) {
            return is_callable($callback) ? call_user_func($callback, $request) : ($callback === true);
        });
    }

    /**
     * Disable adding new rows.
     *
     * @return $this
     */
    public function disableAddingRows()
    {
        $this->canAddRow = false;

        return $this;
    }

    /**
     * Disable deleting rows.
     *
     * @return $this
     */
    public function disableDeletingRows()
    {
        $this->canDeleteRow = false;

        return $this;
    }

    /**
     * Prepare the field element for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'keyLabel' => $this->keyLabel ?? Nova::__('Key'),
            'valueLabel' => $this->valueLabel ?? Nova::__('Value'),
            'actionText' => $this->actionText ?? Nova::__('Add row'),
            'readonlyKeys' => $this->readonlyKeys(app(NovaRequest::class)),
            'canAddRow' => $this->canAddRow,
            'canDeleteRow' => $this->canDeleteRow,
        ]);
    }
}
