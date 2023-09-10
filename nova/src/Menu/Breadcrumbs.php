<?php

namespace Laravel\Nova\Menu;

use JsonSerializable;
use Laravel\Nova\AuthorizedToSee;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Makeable;

class Breadcrumbs implements JsonSerializable
{
    use AuthorizedToSee,
        Makeable;

    /**
     * The breadcrumb's path.
     *
     * @var string|null
     */
    public $items;

    /**
     * Construct a new Breadcrumb instance.
     *
     * @param  string|null  $items
     */
    public function __construct($items = null)
    {
        $this->items = $items;
    }

    /**
     * Set breadcrumb's path.
     *
     * @param  string  $href
     * @return $this
     */
    public function items($href)
    {
        $this->items = $href;

        return $this;
    }

    /**
     * Prepare the menu for JSON serialization.
     *
     * @return array{name: string, path: string|null}|array
     */
    public function jsonSerialize(): array
    {
        return $this->authorizedToSee(app(NovaRequest::class))
            ? $this->items
            : [];
    }
}
