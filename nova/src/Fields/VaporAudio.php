<?php

namespace Laravel\Nova\Fields;

use Illuminate\Support\Facades\Storage;

class VaporAudio extends VaporFile
{
    use PresentsAudio;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'vapor-audio-field';

    /**
     * The file types accepted by the field.
     *
     * @var string
     */
    public $acceptedTypes = 'audio/*';

    /**
     * Create a new field.
     *
     * @param  string  $name
     * @param  string|null  $attribute
     * @param  (callable(\Laravel\Nova\Http\Requests\NovaRequest, object, string, string, ?string, ?string):mixed)|null  $storageCallback
     * @return void
     */
    public function __construct($name, $attribute = null, $storageCallback = null)
    {
        parent::__construct($name, $attribute, $storageCallback);

        $this->preview(function ($value) {
            return $value ? Storage::disk($this->getStorageDisk())->temporaryUrl($value, now()->addMinutes(10)) : null;
        });
    }

    /**
     * Prepare the field element for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), $this->audioAttributes());
    }
}
