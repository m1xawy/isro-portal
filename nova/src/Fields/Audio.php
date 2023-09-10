<?php

namespace Laravel\Nova\Fields;

use Illuminate\Support\Facades\Storage;

class Audio extends File
{
    use PresentsAudio;

    const PRELOAD_AUTO = 'auto';

    const PRELOAD_METADATA = 'metadata';

    const PRELOAD_NONE = 'none';

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'audio-field';

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
     * @param  string|callable|null  $attribute
     * @param  string|null  $disk
     * @param  (callable(\Laravel\Nova\Http\Requests\NovaRequest, object, string, string, ?string, ?string):mixed)|null  $storageCallback
     * @return void
     */
    public function __construct($name, $attribute = null, $disk = 'public', $storageCallback = null)
    {
        parent::__construct($name, $attribute, $disk, $storageCallback);

        $this->preview(function ($value) {
            return $value ? Storage::disk($this->getStorageDisk())->url($value) : null;
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
