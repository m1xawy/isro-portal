<?php

namespace Laravel\Nova\Fields;

use Laravel\Nova\Exceptions\HelperNotSupported;

trait Copyable
{
    /**
     * Indicates if the field value is copyable inside Nova.
     *
     * @var bool
     */
    public $copyable = false;

    /**
     * Allow the field to be copyable to the clipboard inside Nova.
     *
     * @return $this
     *
     * @throws \Laravel\Nova\Exceptions\HelperNotSupported
     */
    public function copyable()
    {
        if ($this->asHtml) {
            throw new HelperNotSupported(sprintf("The `%s::%s` option is not available on fields displayed as HTML. Please remove the `asHtml` method from the {$this->name} field to enable `copyable`.",
                __CLASS__, 'copyable'));
        }

        $this->copyable = true;

        return $this;
    }
}
