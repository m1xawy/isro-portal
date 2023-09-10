<?php

namespace Laravel\Nova\Fields;

use Illuminate\Support\Str;
use Laravel\Nova\Fields\Attachments\DeleteAttachments;
use Laravel\Nova\Fields\Attachments\DetachAttachment;
use Laravel\Nova\Fields\Attachments\DiscardPendingAttachments;
use Laravel\Nova\Fields\Attachments\PendingAttachment;
use Laravel\Nova\Fields\Attachments\StorePendingAttachment;
use Laravel\Nova\Http\Requests\NovaRequest;

trait HasAttachments
{
    use Deletable, Storable;

    /**
     * Indicates if the field should accept files.
     *
     * @var bool
     */
    public $withFiles = false;

    /**
     * The callback that should be executed to store file attachments.
     *
     * @var callable(\Illuminate\Http\Request):string
     */
    public $attachCallback;

    /**
     * The callback that should be executed to delete persisted file attachments.
     *
     * @var callable(\Illuminate\Http\Request):void
     */
    public $detachCallback;

    /**
     * The callback that should be executed to discard file attachments.
     *
     * @var callable(\Illuminate\Http\Request):void
     */
    public $discardCallback;

    /**
     * Specify the callback that should be used to store file attachments.
     *
     * @param  callable(\Illuminate\Http\Request):string  $callback
     * @return $this
     */
    public function attach(callable $callback)
    {
        $this->withFiles = true;

        $this->attachCallback = $callback;

        return $this;
    }

    /**
     * Specify the callback that should be used to delete a single, persisted file attachment.
     *
     * @param  callable(\Illuminate\Http\Request):void  $callback
     * @return $this
     */
    public function detach(callable $callback)
    {
        $this->withFiles = true;

        $this->detachCallback = $callback;

        return $this;
    }

    /**
     * Specify the callback that should be used to discard pending file attachments.
     *
     * @param  callable  $callback
     * @return $this
     */
    public function discard(callable $callback)
    {
        $this->withFiles = true;

        $this->discardCallback = $callback;

        return $this;
    }

    /**
     * Specify the callback that should be used to delete the field.
     *
     * @param  callable(\Laravel\Nova\Http\Requests\NovaRequest, mixed, ?string, ?string):mixed  $deleteCallback
     * @return $this
     */
    public function delete(callable $deleteCallback)
    {
        $this->withFiles = true;

        $this->deleteCallback = $deleteCallback;

        return $this;
    }

    /**
     * Specify that file uploads should be allowed.
     *
     * @param  string  $disk
     * @param  string  $path
     * @return $this
     */
    public function withFiles($disk = null, $path = '/')
    {
        $this->withFiles = true;

        $this->disk($disk)->path($path);

        $this->attach(new StorePendingAttachment($this))
             ->detach(new DetachAttachment())
             ->delete(new DeleteAttachments($this))
             ->discard(new DiscardPendingAttachments())
             ->prunable();

        return $this;
    }

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  string  $requestAttribute
     * @param  \Illuminate\Database\Eloquent\Model|\Laravel\Nova\Support\Fluent  $model
     * @param  string  $attribute
     * @return void|\Closure
     */
    protected function fillAttributeWithAttachment(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        $callbacks = [];

        $maybeCallback = parent::fillAttribute($request, $requestAttribute, $model, $attribute);

        $attribute = Str::replace('.', '->', "{$this->attribute}DraftId");

        if (is_callable($maybeCallback)) {
            $callbacks[] = $maybeCallback;
        }

        if ($request->{$attribute} && $this->withFiles) {
            $callbacks[] = function () use ($request, $model, $attribute) {
                PendingAttachment::persistDraft(
                    $request->{$attribute},
                    $this,
                    $model
                );
            };
        }

        if (count($callbacks)) {
            return function () use ($callbacks) {
                collect($callbacks)->each->__invoke();
            };
        }
    }
}
