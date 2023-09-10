<?php

namespace Laravel\Nova\Menu;

use JsonSerializable;
use Laravel\Nova\AuthorizedToSee;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Makeable;
use Laravel\Nova\Nova;
use Laravel\Nova\Resource;

class Breadcrumb implements JsonSerializable
{
    use AuthorizedToSee,
        Makeable;

    /**
     * The breadcrumb's name.
     *
     * @var string
     */
    public $name;

    /**
     * The breadcrumb's path.
     *
     * @var string|null
     */
    public $path;

    /**
     * Construct a new Breadcrumb instance.
     *
     * @param  string  $name
     * @param  string|null  $path
     */
    public function __construct($name, $path = null)
    {
        $this->name = $name;
        $this->path = $path;
    }

    /**
     * Create a breadcrumb from a resource class.
     *
     * @param  \Laravel\Nova\Resource|class-string<\Laravel\Nova\Resource>  $resourceClass
     * @return static
     */
    public static function resource($resourceClass)
    {
        if ($resourceClass instanceof Resource && $resourceClass->model()->exists === true) {
            return static::make(
                Nova::__(':resource Details: :title', [
                    'resource' => $resourceClass::singularLabel(),
                    'title' => $resourceClass->title(),
                ])
            )->path('/resources/'.$resourceClass::uriKey().'/'.$resourceClass->getKey())
            ->canSee(function ($request) use ($resourceClass) {
                return $resourceClass->authorizedToView($request);
            });
        }

        return static::make(
            Nova::__($resourceClass::label())
        )->path('/resources/'.$resourceClass::uriKey())
        ->canSee(function ($request) use ($resourceClass) {
            return $resourceClass::availableForNavigation($request) && $resourceClass::authorizedToViewAny($request);
        });
    }

    /**
     * Set breadcrumb's path.
     *
     * @param  string  $href
     * @return $this
     */
    public function path($href)
    {
        $this->path = $href;

        return $this;
    }

    /**
     * Prepare the menu for JSON serialization.
     *
     * @return array{name: string, path: string|null}
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'path' => $this->authorizedToSee(app(NovaRequest::class)) ? $this->path : null,
        ];
    }
}
