<?php

namespace Laravel\Nova\Fields;

use Illuminate\Support\Arr;
use Laravel\Nova\Contracts\Deletable as DeletableContract;
use Laravel\Nova\Contracts\FilterableField;
use Laravel\Nova\Contracts\Previewable;
use Laravel\Nova\Contracts\Storable as StorableContract;
use Laravel\Nova\Fields\Filters\TextFilter;
use Laravel\Nova\Fields\Markdown\CommonMarkPreset;
use Laravel\Nova\Fields\Markdown\DefaultPreset;
use Laravel\Nova\Fields\Markdown\ZeroPreset;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\ManagesPresets;

class Markdown extends Field implements DeletableContract, FilterableField, Previewable, StorableContract
{
    use Expandable;
    use FieldFilterable;
    use HasAttachments;
    use Storable;
    use SupportsDependentFields;
    use ManagesPresets;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'markdown-field';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    /**
     * The built-in presets for the Markdown field.
     *
     * @var string[]
     */
    public $presets = [
        'default' => DefaultPreset::class,
        'commonmark' => CommonMarkPreset::class,
        'zero' => ZeroPreset::class,
    ];

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  string  $requestAttribute
     * @param  \Illuminate\Database\Eloquent\Model|\Laravel\Nova\Support\Fluent  $model
     * @param  string  $attribute
     * @return void|\Closure
     */
    protected function fillAttribute(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        return $this->fillAttributeWithAttachment($request, $requestAttribute, $model, $attribute);
    }

    /**
     * Get the full path that the field is stored at on disk.
     *
     * @return string|null
     */
    public function getStoragePath()
    {
        return null;
    }

    /**
     * Make the field filter.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return \Laravel\Nova\Fields\Filters\Filter
     */
    protected function makeFilter(NovaRequest $request)
    {
        return new TextFilter($this);
    }

    /**
     * Prepare the field for JSON serialization.
     *
     * @return array
     */
    public function serializeForFilter()
    {
        return transform($this->jsonSerialize(), function ($field) {
            return Arr::only($field, [
                'uniqueKey',
                'name',
                'attribute',
            ]);
        });
    }

    /**
     * Return a preview for the given field value.
     *
     * @param  string|null  $value
     * @return string
     */
    public function previewFor($value)
    {
        return $this->renderer()->convert($value ?? '');
    }

    /**
     * @return \Laravel\Nova\Fields\Markdown\MarkdownPreset
     */
    public function renderer()
    {
        return new $this->presets[$this->preset];
    }

    /**
     * Prepare the element for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'shouldShow' => $this->shouldBeExpanded(),
            'preset' => $this->preset,
            'previewFor' => $this->previewFor($this->value ?? ''),
            'withFiles' => $this->withFiles,
        ]);
    }
}
