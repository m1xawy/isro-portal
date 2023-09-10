<?php

namespace Laravel\Nova\Fields;

trait Collapsable
{
    /**
     * The menu's collapsable state.
     *
     * @var bool
     */
    public $collapsable = false;

    /**
     * Determines whether the menu section should be collapsed by default.
     *
     * @var bool
     */
    public $collapsedByDefault = false;

    /**
     * Set the menu group as collapsable.
     *
     * @return $this
     */
    public function collapsable()
    {
        $this->collapsable = true;

        return $this;
    }

    /**
     * Set the menu group as collapsable.
     *
     * @return $this
     */
    public function collapsible()
    {
        return $this->collapsable();
    }

    /**
     * Set the menu section as collapsed by default.
     *
     * @return $this
     */
    public function collapsedByDefault()
    {
        $this->collapsable();
        $this->collapsedByDefault = true;

        return $this;
    }
}
