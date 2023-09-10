<?php

namespace Laravel\Nova\Testing\Browser\Components;

use Laravel\Dusk\Browser;

class BreadcrumbComponent extends Component
{
    /**
     * Get the root selector for the component.
     *
     * @return string
     */
    public function selector()
    {
        return 'nav[aria-label="breadcrumb"]';
    }

    /**
     * Assert current page match the title.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $title
     * @return void
     */
    public function assertCurrentPageTitle(Browser $browser, string $title)
    {
        $browser->assertSeeIn('@current-page', $title);
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@current-page' => 'li[aria-current="page"]',
        ];
    }
}
