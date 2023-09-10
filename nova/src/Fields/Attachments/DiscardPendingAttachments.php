<?php

namespace Laravel\Nova\Fields\Attachments;

use Illuminate\Http\Request;

class DiscardPendingAttachments
{
    /**
     * The pending attachment model.
     *
     * @var class-string<\Laravel\Nova\Fields\Attachments\PendingAttachment>
     */
    public static $model = PendingAttachment::class;

    /**
     * Discard pending attachments on the field.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __invoke(Request $request)
    {
        static::$model::where('draft_id', $request->draftId)
                    ->get()
                    ->each
                    ->purge();
    }
}
