<?php

namespace Laravel\Nova\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Laravel\Nova\Http\Requests\NovaRequest;

class FieldAttachmentController extends Controller
{
    /**
     * Store an attachment for a Trix field.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(NovaRequest $request)
    {
        /** @var \Laravel\Nova\Fields\Field&\Laravel\Nova\Contracts\Storable $field */
        $field = $request->newResource()
                        ->availableFields($request)
                        ->filter(function ($field) {
                            return optional($field)->withFiles === true;
                        })
                        ->findFieldByAttribute($request->field, function () {
                            abort(404);
                        });

        /** @phpstan-ignore-next-line */
        $url = call_user_func($field->attachCallback, $request);

        return response()->json(['url' => $url]);
    }

    /**
     * Delete a single, persisted attachment for a Trix field by URL.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyAttachment(NovaRequest $request)
    {
        /** @var \Laravel\Nova\Fields\Field&\Laravel\Nova\Contracts\Storable $field */
        $field = $request->newResource()
                        ->availableFields($request)
                        ->filter(function ($field) {
                            return optional($field)->withFiles === true;
                        })
                        ->findFieldByAttribute($request->field, function () {
                            abort(404);
                        });

        /** @phpstan-ignore-next-line */
        call_user_func($field->detachCallback, $request);

        return response()->noContent(200);
    }

    /**
     * Purge all pending attachments for a Trix field.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyPending(NovaRequest $request)
    {
        /** @var \Laravel\Nova\Fields\Field&\Laravel\Nova\Contracts\Storable $field */
        $field = $request->newResource()
                        ->availableFields($request)
                        ->filter(function ($field) {
                            return optional($field)->withFiles === true;
                        })
                        ->findFieldByAttribute($request->field, function () {
                            abort(404);
                        });

        /** @phpstan-ignore-next-line */
        call_user_func($field->discardCallback, $request);

        return response()->noContent(200);
    }

    /**
     * Return a new draft ID for the field.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function draftId(NovaRequest $request)
    {
        return response()->json([
            'draftId' => Str::uuid(),
        ]);
    }
}
