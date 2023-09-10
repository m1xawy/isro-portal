<?php

namespace Laravel\Nova\Actions;

use Closure;
use Illuminate\Bus\PendingBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;
use JsonSerializable;
use Laravel\Nova\AuthorizedToSee;
use Laravel\Nova\Exceptions\MissingActionHandlerException;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\FieldCollection;
use Laravel\Nova\Http\Requests\ActionRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Makeable;
use Laravel\Nova\Metable;
use Laravel\Nova\Nova;
use Laravel\Nova\ProxiesCanSeeToGate;
use ReflectionClass;

/**
 * @phpstan-type TAuthoriseCallback \Closure(\Laravel\Nova\Http\Requests\NovaRequest):bool
 *
 * @phpstan-property TAuthoriseCallback|null $seeCallback
 *
 * @phpstan-method $this canSee(TAuthoriseCallback $callback)
 *
 * @property \Closure|null $seeCallback
 *
 * @method $this canSee(\Closure $callback)
 */
class Action implements JsonSerializable
{
    use AuthorizedToSee,
        Macroable,
        Makeable,
        Metable,
        ProxiesCanSeeToGate,
        Tappable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name;

    /**
     * The URI key of the action.
     *
     * @var string|null
     */
    public $uriKey;

    /**
     * The action's component.
     *
     * @var string
     */
    public $component = 'confirm-action-modal';

    /**
     * Indicates if need to skip log action events for models.
     *
     * @var bool
     */
    public $withoutActionEvents = false;

    /**
     * Determine where the action redirection should be without confirmation.
     *
     * @var bool
     */
    public $withoutConfirmation = false;

    /**
     * Indicates if this action is only available on the resource index view.
     *
     * @var bool
     */
    public $onlyOnIndex = false;

    /**
     * Indicates if this action is only available on the resource detail view.
     *
     * @var bool
     */
    public $onlyOnDetail = false;

    /**
     * Indicates if this action is available on the resource index view.
     *
     * @var bool
     */
    public $showOnIndex = true;

    /**
     * Indicates if this action is available on the resource detail view.
     *
     * @var bool
     */
    public $showOnDetail = true;

    /**
     * Indicates if this action is available on the resource's table row.
     *
     * @var bool
     */
    public $showInline = false;

    /**
     * The current batch ID being handled by the action.
     *
     * @var string|null
     */
    public $actionBatchId;

    /**
     * The callback used to authorize running the action.
     *
     * @var (\Closure(\Laravel\Nova\Http\Requests\NovaRequest, mixed):(bool))|null
     */
    public $runCallback;

    /**
     * The callback that should be invoked when the action has completed.
     *
     * @var (\Closure(\Illuminate\Support\Collection):(mixed))|null
     */
    public $thenCallback;

    /**
     * The number of models that should be included in each chunk.
     *
     * @var int
     */
    public static $chunkCount = 200;

    /**
     * The text to be used for the action's confirm button.
     *
     * @var string
     */
    public $confirmButtonText = 'Run Action';

    /**
     * The text to be used for the action's cancel button.
     *
     * @var string
     */
    public $cancelButtonText = 'Cancel';

    /**
     * The text to be used for the action's confirmation text.
     *
     * @var string
     */
    public $confirmText = 'Are you sure you want to run this action?';

    /**
     * Indicates if the action can be run without any models.
     *
     * @var bool
     */
    public $standalone = false;

    /**
     * Indicates if the action can be run with a single selected model.
     *
     * @var bool
     */
    public $sole = false;

    /**
     * The XHR response type on executing the action.
     *
     * @var string
     */
    public $responseType = 'json';

    /**
     * The size of the modal. Can be "sm", "md", "lg", "xl", "2xl", "3xl", "4xl", "5xl", "6xl", "7xl".
     *
     * @var string
     */
    public $modalSize = '2xl';

    /**
     * The style of the modal. Can be either 'fullscreen' or 'window'.
     *
     * @var string
     */
    public $modalStyle = 'window';

    public const FULLSCREEN_STYLE = 'fullscreen';

    public const WINDOW_STYLE = 'window';

    /**
     * The closure used to handle the action.
     *
     * @var (\Closure(\Laravel\Nova\Fields\ActionFields, \Illuminate\Support\Collection):(mixed))|null
     */
    public $handleCallback;

    /**
     * Create a new action using the given callback.
     *
     * @param  string  $name
     * @param  \Closure(\Laravel\Nova\Fields\ActionFields, \Illuminate\Support\Collection):(mixed)  $handleUsing
     * @return static
     */
    public static function using($name, Closure $handleUsing)
    {
        return (new static)
            ->withName($name)
            ->handleUsing($handleUsing);
    }

    /**
     * Determine if the action is executable for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function authorizedToRun(Request $request, $model)
    {
        return $this->runCallback ? call_user_func($this->runCallback, $request, $model) : true;
    }

    /**
     * Return a message response from the action.
     *
     * @param  string  $message
     * @return \Laravel\Nova\Actions\ActionResponse
     */
    public static function message($message)
    {
        return ActionResponse::message($message);
    }

    /**
     * Return a dangerous message response from the action.
     *
     * @param  string  $name
     * @param  string|null  $message
     * @return static|\Laravel\Nova\Actions\ActionResponse
     */
    public static function danger($name, string $message = null)
    {
        if (\func_num_args() === 2) {
            return (new static)
                ->withName($name)
                ->noop()
                ->then(function () use ($message) {
                    return ActionResponse::danger($message);
                });
        }

        return ActionResponse::danger($name);
    }

    /**
     * Return a delete response from the action.
     *
     * @return static|\Laravel\Nova\Actions\ActionResponse
     */
    public static function deleted()
    {
        return ActionResponse::deleted();
    }

    /**
     * Return a redirect response from the action.
     *
     * @param  string  $name
     * @param  (\Closure():(string))|(\Closure(\Illuminate\Database\Eloquent\Model):(string))|string|null  $url
     * @return static|\Laravel\Nova\Actions\ActionResponse
     */
    public static function redirect($name, $url = null)
    {
        if (\func_num_args() === 2) {
            return (new static)
                ->withName($name)
                ->noop()
                ->tap(function ($action) use ($url) {
                    $action->handleUsing(function ($fields, $models) use ($action, $url) {
                        if ($action->sole === true) {
                            return ActionResponse::redirect(value($url, $models->first()));
                        }

                        return ActionResponse::redirect(value($url));
                    });
                })
                ->then(function ($response) {
                    return $response->first();
                });
        }

        return ActionResponse::redirect($name);
    }

    /**
     * Return a Inertia visit from the action.
     *
     * @deprecated Use "visit"
     *
     * @param  string  $name
     * @param  (\Closure():(string))|(\Closure(\Illuminate\Database\Eloquent\Model):(string))|string|array<string, mixed>  $path
     * @param  array<string, mixed>  $options
     * @return static|\Laravel\Nova\Actions\ActionResponse
     */
    public static function push($name, $path, $options = [])
    {
        return self::visit($name, $path, $options);
    }

    /**
     * Return a Inertia visit from the action.
     *
     * @param  string  $name
     * @param  (\Closure():(string))|(\Closure(\Illuminate\Database\Eloquent\Model):(string))|string|array<string, mixed>  $path
     * @param  array<string, mixed>  $options
     * @return static|\Laravel\Nova\Actions\ActionResponse
     */
    public static function visit($name, $path = [], $options = [])
    {
        if (\func_num_args() === 3) {
            return (new static)
                ->withName($name)
                ->noop()
                ->tap(function ($action) use ($path, $options) {
                    $action->handleUsing(function ($fields, $models) use ($action, $path, $options) {
                        if ($action->sole === true) {
                            return ActionResponse::visit(value($path, $models->first()), $options);
                        }

                        return ActionResponse::visit(value($path), $options);
                    });
                })
                ->then(function ($response) {
                    return $response->first();
                });
        }

        return ActionResponse::visit($name, $path);
    }

    /**
     * Return an open in new tab response from the action.
     *
     * @param  string  $name
     * @param  (\Closure():(string))|(\Closure(\Illuminate\Database\Eloquent\Model):(string))|string|null  $url
     * @return static|\Laravel\Nova\Actions\ActionResponse
     */
    public static function openInNewTab($name, $url = null)
    {
        if (\func_num_args() === 2) {
            return (new static)
                ->withName($name)
                ->noop()
                ->tap(function ($action) use ($url) {
                    $action->handleUsing(function ($fields, $models) use ($action, $url) {
                        if ($action->sole === true) {
                            return ActionResponse::openInNewTab(value($url, $models->first()));
                        }

                        return ActionResponse::openInNewTab(value($url));
                    });
                })
                ->then(function ($response) {
                    return $response->first();
                });
        }

        return ActionResponse::openInNewTab($name);
    }

    /**
     * Return a download response from the action.
     *
     * @deprecated Use "downloadURL"
     *
     * @param  string  $name
     * @param  string  $url
     * @return static|\Laravel\Nova\Actions\ActionResponse
     */
    public static function download($url, $name)
    {
        return ActionResponse::download($name, $url);
    }

    /**
     * Return a download response from the action.
     *
     * @param  string  $name
     * @param  (\Closure():(string))|(\Closure(\Illuminate\Database\Eloquent\Model):(string))|string  $url
     * @return static|\Laravel\Nova\Actions\ActionResponse
     */
    public static function downloadURL($name, $url)
    {
        if (\func_num_args() === 2) {
            return (new static)
                ->withName($name)
                ->noop()
                ->tap(function ($action) use ($name, $url) {
                    $action->handleUsing(function ($fields, $models) use ($action, $name, $url) {
                        if ($action->sole === true) {
                            return ActionResponse::download($name, value($url, $models->first()));
                        }

                        return ActionResponse::download($name, value($url));
                    });
                })
                ->then(function ($response) {
                    return $response->first();
                });
        }

        // We have to support the old method of calling this action
        // where the parameters are passed in the opposite order.
        return self::download($url, $name);
    }

    /**
     * Return an action modal response from the action.
     *
     * @param  string  $name
     * @param  string|array<string, mixed>  $modal
     * @param  (\Closure():(array<string, mixed>))|(\Closure(\Illuminate\Database\Eloquent\Model):(array<string, mixed>))|array<string, mixed>  $data
     * @return static|\Laravel\Nova\Actions\ActionResponse
     */
    public static function modal($name, $modal = [], $data = [])
    {
        if (\func_num_args() === 3) {
            return (new static)
                ->withName($name)
                ->noop()
                ->tap(function ($action) use ($modal, $data) {
                    $action->handleUsing(function ($fields, $models) use ($action, $modal, $data) {
                        if ($action->sole === true) {
                            return ActionResponse::modal($modal, value($data, $models->first()));
                        }

                        return ActionResponse::modal($modal, value($data));
                    });
                })
                ->then(function ($response) {
                    return $response->first();
                });
        }

        return ActionResponse::modal($name, $modal);
    }

    /**
     * Set the Closure used to handle the action.
     *
     * @param  \Closure(\Laravel\Nova\Fields\ActionFields, \Illuminate\Support\Collection):(mixed)  $callback
     * @return $this
     */
    public function handleUsing(Closure $callback)
    {
        $this->handleCallback = $callback;

        return $this;
    }

    /**
     * Set the Action to be a no-op.
     *
     * @return $this
     */
    public function noop()
    {
        return $this->handleUsing(function () {
            return null;
        });
    }

    /**
     * Set the Action to be available only when single resource is selected.
     *
     * @return $this
     */
    public function sole()
    {
        $this->standalone = false;
        $this->sole = true;

        return $this->canSee(function (NovaRequest $request) {
            return ! $request->allResourcesSelected() && $request->selectedResourceIds()->count() === 1;
        })->showInline()
        ->showOnDetail();
    }

    /**
     * Perform the action on the given models using the provided handle callback.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handleUsingCallback(ActionFields $fields, Collection $models)
    {
        return value($this->handleCallback, $fields, $models);
    }

    /**
     * Execute the action for the given request.
     *
     * @param  \Laravel\Nova\Http\Requests\ActionRequest  $request
     * @return mixed
     *
     * @throws \Laravel\Nova\Exceptions\MissingActionHandlerException|\Throwable
     */
    public function handleRequest(ActionRequest $request)
    {
        $fields = $request->resolveFields();

        $dispatcher = new DispatchAction($request, $this, $fields);

        if (method_exists($this, 'dispatchRequestUsing')) {
            $dispatcher->handleUsing($request, function ($request, $response, $fields) {
                return $this->dispatchRequestUsing($request, $response, $fields);
            });
        } else {
            $method = ActionMethod::determine($this, $request->targetModel());

            if (! method_exists($this, $method)) {
                throw MissingActionHandlerException::make($this, $method);
            }

            $this->standalone
                ? $dispatcher->handleStandalone($method)
                : $dispatcher->handleRequest($request, $method, static::$chunkCount);
        }

        $response = $dispatcher->dispatch();

        if (! $response->wasExecuted) {
            return static::danger(Nova::__('Sorry! You are not authorized to perform this action.'));
        }

        if ($this->thenCallback) {
            return call_user_func($this->thenCallback, collect($response->results)->flatten());
        }

        return $this->handleResult($fields, $response->results);
    }

    /**
     * Handle chunk results.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  array<int, mixed>  $results
     * @return mixed
     */
    public function handleResult(ActionFields $fields, $results)
    {
        return count($results) ? end($results) : null;
    }

    /**
     * Handle any post-validation processing.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    protected function afterValidation(NovaRequest $request, $validator)
    {
        //
    }

    /**
     * Mark the action event record for the model as finished.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return int
     */
    protected function markAsFinished($model)
    {
        return $this->actionBatchId ? Nova::usingActionEvent(function ($actionEvent) use ($model) {
            $actionEvent->markAsFinished($this->actionBatchId, $model);
        }) : 0;
    }

    /**
     * Mark the action event record for the model as failed.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  \Throwable|string  $e
     * @return int
     */
    protected function markAsFailed($model, $e = null)
    {
        return $this->actionBatchId ? Nova::usingActionEvent(function ($actionEvent) use ($model, $e) {
            $actionEvent->markAsFailed($this->actionBatchId, $model, $e);
        }) : 0;
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }

    /**
     * Validate the given request.
     *
     * @param  \Laravel\Nova\Http\Requests\ActionRequest  $request
     * @return array<string, mixed>
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateFields(ActionRequest $request)
    {
        $fields = FieldCollection::make($this->fields($request))
                    ->authorized($request)
                    ->applyDependsOn($request)
                    ->withoutReadonly($request)
                    ->withoutUnfillable();

        return Validator::make(
            $request->all(),
            $fields->mapWithKeys(function ($field) use ($request) {
                return $field->getCreationRules($request);
            })->all(),
            [],
            $fields->reject(function ($field) {
                return empty($field->name);
            })->mapWithKeys(function ($field) {
                return [$field->attribute => $field->name];
            })->all()
        )->after(function ($validator) use ($request) {
            $this->afterValidation($request, $validator);
        })->validate();
    }

    /**
     * Indicate that this action is only available on the resource index view.
     *
     * @param  bool  $value
     * @return $this
     */
    public function onlyOnIndex($value = true)
    {
        $this->onlyOnIndex = $value;
        $this->showOnIndex = $value;
        $this->showOnDetail = ! $value;
        $this->showInline = ! $value;

        return $this;
    }

    /**
     * Indicate that this action is available except on the resource index view.
     *
     * @return $this
     */
    public function exceptOnIndex()
    {
        $this->showOnDetail = true;
        $this->showInline = true;
        $this->showOnIndex = false;

        return $this;
    }

    /**
     * Indicate that this action is only available on the resource detail view.
     *
     * @param  bool  $value
     * @return $this
     */
    public function onlyOnDetail($value = true)
    {
        $this->onlyOnDetail = $value;
        $this->showOnDetail = $value;
        $this->showOnIndex = ! $value;
        $this->showInline = ! $value;

        return $this;
    }

    /**
     * Indicate that this action is available except on the resource detail view.
     *
     * @return $this
     */
    public function exceptOnDetail()
    {
        $this->showOnIndex = true;
        $this->showOnDetail = false;
        $this->showInline = true;

        return $this;
    }

    /**
     * Indicate that this action is only available on the resource's table row.
     *
     * @param  bool  $value
     * @return $this
     */
    public function onlyOnTableRow($value = true)
    {
        return $this->onlyInline($value);
    }

    /**
     * Indicate that this action is only available on the resource's table row.
     *
     * @param  bool  $value
     * @return $this
     */
    public function onlyInline($value = true)
    {
        $this->showInline = $value;
        $this->showOnIndex = ! $value;
        $this->showOnDetail = ! $value;

        return $this;
    }

    /**
     * Indicate that this action is available except on the resource's table row.
     *
     * @return $this
     */
    public function exceptOnTableRow()
    {
        return $this->exceptInline();
    }

    /**
     * Indicate that this action is available except on the resource's table row.
     *
     * @return $this
     */
    public function exceptInline()
    {
        $this->showInline = false;
        $this->showOnIndex = true;
        $this->showOnDetail = true;

        return $this;
    }

    /**
     * Show the action on the index view.
     *
     * @return $this
     */
    public function showOnIndex()
    {
        $this->showOnIndex = true;

        return $this;
    }

    /**
     * Show the action on the detail view.
     *
     * @return $this
     */
    public function showOnDetail()
    {
        $this->showOnDetail = true;

        return $this;
    }

    /**
     * Show the action on the table row.
     *
     * @deprecated Use "showInline"
     *
     * @return $this
     */
    public function showOnTableRow()
    {
        return $this->showInline();
    }

    /**
     * Show the action on the table row.
     *
     * @return $this
     */
    public function showInline()
    {
        $this->showInline = true;

        return $this;
    }

    /**
     * Register a callback that should be invoked after the action is finished executing.
     *
     * @param  callable(\Illuminate\Support\Collection):mixed  $callback
     * @return $this
     */
    public function then($callback)
    {
        $this->thenCallback = $callback;

        return $this;
    }

    /**
     * Set the current batch ID being handled by the action.
     *
     * @param  string  $actionBatchId
     * @return $this
     */
    public function withActionBatchId(string $actionBatchId)
    {
        $this->actionBatchId = $actionBatchId;

        return $this;
    }

    /**
     * Register `then`, `catch`, and `finally` callbacks on the pending batch.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Bus\PendingBatch  $batch
     * @return void
     */
    public function withBatch(ActionFields $fields, PendingBatch $batch)
    {
        //
    }

    /**
     * Set the callback to be run to authorize running the action.
     *
     * @param  \Closure(\Laravel\Nova\Http\Requests\NovaRequest, mixed):bool  $callback
     * @return $this
     */
    public function canRun(Closure $callback)
    {
        $this->runCallback = $callback;

        return $this;
    }

    /**
     * Get the component name for the action.
     *
     * @return string
     */
    public function component()
    {
        return $this->component;
    }

    /**
     * Set the name for the action.
     *
     * @param  string  $name
     * @return $this
     */
    public function withName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the URI key for the action.
     *
     * @param  string  $uriKey
     * @return $this
     */
    public function withUriKey($uriKey)
    {
        $this->uriKey = $uriKey;

        return $this;
    }

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name()
    {
        return $this->name ?: Nova::humanize($this);
    }

    /**
     * Get the URI key for the action.
     *
     * @return string
     */
    public function uriKey()
    {
        return $this->uriKey ?? Str::slug($this->name(), '-', null);
    }

    /**
     * Set the action to execute instantly.
     *
     * @return $this
     */
    public function withoutConfirmation()
    {
        $this->withoutConfirmation = true;

        return $this;
    }

    /**
     * Set the action to skip action events for models.
     *
     * @return $this
     */
    public function withoutActionEvents()
    {
        $this->withoutActionEvents = true;

        return $this;
    }

    /**
     * Determine if the action is to be shown on the index view.
     *
     * @return bool
     */
    public function shownOnIndex()
    {
        if ($this->onlyOnIndex == true) {
            return true;
        }

        if ($this->onlyOnDetail) {
            return false;
        }

        return $this->showOnIndex;
    }

    /**
     * Determine if the action is to be shown on the detail view.
     *
     * @return bool
     */
    public function shownOnDetail()
    {
        if ($this->onlyOnDetail) {
            return true;
        }

        if ($this->onlyOnIndex) {
            return false;
        }

        return $this->showOnDetail;
    }

    /**
     * Determine if the action is to be shown inline on the table row.
     *
     * @return bool
     */
    public function shownOnTableRow()
    {
        return $this->showInline;
    }

    /**
     * Set the text for the action's confirmation button.
     *
     * @param  string  $text
     * @return $this
     */
    public function confirmButtonText($text)
    {
        $this->confirmButtonText = $text;

        return $this;
    }

    /**
     * Set the text for the action's cancel button.
     *
     * @param  string  $text
     * @return $this
     */
    public function cancelButtonText($text)
    {
        $this->cancelButtonText = $text;

        return $this;
    }

    /**
     * Set the text for the action's confirmation message.
     *
     * @param  string  $text
     * @return $this
     */
    public function confirmText($text)
    {
        $this->confirmText = $text;

        return $this;
    }

    /**
     * Mark the action as a standalone action.
     *
     * @return $this
     */
    public function standalone()
    {
        $this->standalone = true;
        $this->sole = false;

        return $this;
    }

    /**
     * Determine if the action is a standalone action.
     *
     * @return bool
     */
    public function isStandalone()
    {
        return $this->standalone;
    }

    /**
     * Set the modal to fullscreen style.
     *
     * @return $this
     */
    public function fullscreen()
    {
        $this->modalStyle = static::FULLSCREEN_STYLE;

        return $this;
    }

    /**
     * Set the size of the modal window.
     *
     * @param  string  $size
     * @return $this
     */
    public function size($size)
    {
        $this->modalStyle = static::WINDOW_STYLE;
        $this->modalSize = $size;

        return $this;
    }

    /**
     * Prepare the action for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $request = app(NovaRequest::class);

        return array_merge([
            'cancelButtonText' => Nova::__($this->cancelButtonText),
            'component' => $this->component(),
            'confirmButtonText' => Nova::__($this->confirmButtonText),
            'confirmText' => Nova::__($this->confirmText),
            'destructive' => $this instanceof DestructiveAction,
            'name' => $this->name(),
            'uriKey' => $this->uriKey(),
            'fields' => FieldCollection::make($this->fields($request))
                ->filter->authorizedToSee($request)
                ->each->resolveForAction($request)
                ->applyDependsOnWithDefaultValues($request)
                ->values()
                ->all(),
            'showOnDetail' => $this->shownOnDetail(),
            'showOnIndex' => $this->shownOnIndex(),
            'showOnTableRow' => $this->shownOnTableRow(),
            'standalone' => $this->isStandalone(),
            'modalSize' => $this->modalSize,
            'modalStyle' => $this->modalStyle,
            'responseType' => $this->responseType,
            'withoutConfirmation' => $this->withoutConfirmation,
        ], $this->meta());
    }

    /**
     * Prepare the instance for serialization.
     *
     * @return array
     */
    public function __sleep()
    {
        $properties = (new ReflectionClass($this))->getProperties();

        return array_values(array_filter(array_map(function ($p) {
            return ($p->isStatic() || in_array($name = $p->getName(), ['runCallback', 'seeCallback', 'thenCallback'])) ? null : $name;
        }, $properties)));
    }
}
