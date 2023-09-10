<?php

namespace Laravel\Nova\Fields;

use Laravel\Nova\Exceptions\HelperNotSupported;

trait AsHTML
{
    /**
     * Indicates if the field value should be displayed as HTML.
     *
     * @var bool
     */
    public $asHtml = false;

    /**
     * Display the field as raw HTML using Vue.
     *
     * @return $this
     *
     * @throws \Laravel\Nova\Exceptions\HelperNotSupported
     */
    public function asHtml()
    {
        if ($this->copyable) {
            throw new HelperNotSupported("The `asHtml` option is not available on fields set to `copyable`. Please remove the `copyable` method from the {$this->name} field to enable `asHtml`.");
        }

        $this->asHtml = true;

        return $this;
    }
}
