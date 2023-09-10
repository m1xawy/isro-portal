<?php

namespace Laravel\Nova\Fields\Attachments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Contracts\Storable;

/**
 * @property string $attachment
 * @property string $disk
 */
class PendingAttachment extends Model
{
    use Prunable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nova_pending_field_attachments';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The persist attachment model.
     *
     * @var class-string<\Laravel\Nova\Fields\Attachments\Attachment>
     */
    protected static $persistModel = Attachment::class;

    /**
     * Get persist model instance.
     *
     * @return \Laravel\Nova\Fields\Attachments\Attachment
     */
    public function getPersistModel()
    {
        return new static::$persistModel;
    }

    /**
     * Persist the given draft's pending attachments.
     *
     * @param  string  $draftId
     * @param  \Laravel\Nova\Contracts\Storable  $field
     * @param  mixed  $model
     * @return void
     *
     * @phpstan-param \Laravel\Nova\Fields\Field&\Laravel\Nova\Contracts\Storable  $field
     */
    public static function persistDraft($draftId, Storable $field, $model)
    {
        static::where('draft_id', $draftId)->get()->each->persist($field, $model);
    }

    /**
     * Persist the pending attachment.
     *
     * @param  \Laravel\Nova\Contracts\Storable  $field
     * @param  mixed  $model
     * @return void
     *
     * @phpstan-param \Laravel\Nova\Fields\Field&\Laravel\Nova\Contracts\Storable  $field
     */
    public function persist(Storable $field, $model)
    {
        $disk = $field->getStorageDisk() ?? $field->getDefaultStorageDisk();

        static::$persistModel::create([
            'attachable_type' => $model->getMorphClass(),
            'attachable_id' => $model->getKey(),
            'attachment' => $this->attachment,
            'disk' => $disk,
            'url' => Storage::disk($disk)->url($this->attachment),
        ]);

        $this->delete();
    }

    /**
     * Get the prunable model query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function prunable()
    {
        return static::where('created_at', '<=', now()->subDays(1));
    }

    /**
     * Prepare the model for pruning.
     *
     * @return void
     */
    protected function pruning()
    {
        Storage::disk($this->disk)->delete($this->attachment);
    }

    /**
     * Purge the attachment.
     *
     * @return void
     */
    public function purge()
    {
        $this->prune();
    }
}
