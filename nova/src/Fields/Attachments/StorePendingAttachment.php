<?php

namespace Laravel\Nova\Fields\Attachments;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Contracts\Storable;

class StorePendingAttachment
{
    /**
     * The field instance.
     *
     * @var \Laravel\Nova\Fields\Field&\Laravel\Nova\Contracts\Storable
     */
    public $field;

    /**
     * The pending attachment model.
     *
     * @var class-string<\Laravel\Nova\Fields\Attachments\PendingAttachment>
     */
    public static $model = PendingAttachment::class;

    /**
     * Create a new invokable instance.
     *
     * @param  \Laravel\Nova\Contracts\Storable  $field
     * @return void
     *
     * @phpstan-param \Laravel\Nova\Fields\Field&\Laravel\Nova\Contracts\Storable $field
     */
    public function __construct(Storable $field)
    {
        $this->field = $field;
    }

    /**
     * Attach a pending attachment to the field.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'attachment' => ['required', 'file'],
        ]);

        $disk = $this->field->getStorageDisk() ?? $this->field->getDefaultStorageDisk();

        return Storage::disk($disk)->url(static::$model::create([
            'draft_id' => $request->draftId,
            'attachment' => $request->file('attachment')->store($this->field->getStorageDir(), $disk),
            'disk' => $disk,
        ])->attachment);
    }
}
