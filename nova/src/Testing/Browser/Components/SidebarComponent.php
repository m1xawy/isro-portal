<?php

namespace Laravel\Nova\Testing\Browser\Components;

use Laravel\Dusk\Browser;

class SidebarComponent extends Component
{
    /**
     * The screen size 'desktop', 'responsive'.
     *
     * @var string
     */
    public $screen = 'desktop';

    /**
     * Create a new component instance.
     *
     * @param  string|null  $screen
     * @return void
     */
    public function __construct($screen = null)
    {
        $this->screen = $screen ?? $this->screen;
    }

    /**
     * Get the root selector for the component.
     *
     * @return string
     */
    public function selector()
    {
        return 'div[dusk="sidebar-menu"][role="navigation"][data-screen="'.$this->screen.'"]';
    }

    /**
     * Assert that the browser page contains the component.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     *
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function assert(Browser $browser)
    {
        tap($this->selector(), function ($selector) use ($browser) {
            $browser->scrollIntoView($selector);
        });
    }

    /**
     * Get the element shortcuts for the component.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@current-active-link' => '> div.sidebar-section div.sidebar-item a.inertia-link-active',
        ];
    }
}
