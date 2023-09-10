<?php

namespace Laravel\Nova\Testing\Browser\Components\Controls;

class RelationSelectControlComponent extends SelectControlComponent
{
    /**
     * Get the root selector associated with this component.
     *
     * @return string
     */
    public function selector()
    {
        return "select[dusk='{$this->attribute}-select']";
    }
}
