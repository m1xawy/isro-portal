<?php

namespace Laravel\Nova\Testing\Browser\Components\Controls;

use Laravel\Nova\Testing\Browser\Components\Component;

class SelectControlComponent extends Component
{
    public $attribute;

    /**
     * Create a new component instance.
     *
     * @param  string  $attribute
     * @return void
     */
    public function __construct(string $attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * Get the root selector associated with this component.
     *
     * @return string
     */
    public function selector()
    {
        return "select[dusk='{$this->attribute}']";
    }
}
