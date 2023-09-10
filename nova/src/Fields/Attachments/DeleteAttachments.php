<?php

namespace Laravel\Nova\Fields\Attachments;

use Illuminate\Http\Request;

class DeleteAttachments
{
    /**
     * The field instance.
     *
     * @var \Laravel\Nova\Fields\Field&\Laravel\Nova\Contracts\Storable
     */
    public $field;

    /**
     * The attachment model.
     *
     * @var class-string<\Laravel\Nova\Fields\Attachments\Attachment>
     */
    public static $model = Attachment::class;

    /**
     * Create a new class instance.
     *
     * @param  \Laravel\Nova\Fields\Field&\Laravel\Nova\Contracts\Storable  $field
     * @return void
     */
    public function __construct($field)
    {
        $this->field = $field;
    }

    /**
     * Delete the attachments associated with the field.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $model
     * @return array
     */
    public function __invoke(Request $request, $model)
    {
        static::$model::query()
                ->where('attachable_type', $model->getMorphClass())
                ->where('attachable_id', $model->getKey())
                ->get()
                ->each
                ->purge();

        return [$this->field->attribute => ''];
    }
}
