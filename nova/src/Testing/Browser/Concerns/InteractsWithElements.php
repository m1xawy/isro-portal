<?php

namespace Laravel\Nova\Testing\Browser\Concerns;

use Carbon\CarbonInterface;
use Illuminate\Support\Env;
use Laravel\Dusk\Browser;

trait InteractsWithElements
{
    /**
     * Dismiss toasted messages.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     */
    public function dismissToasted(Browser $browser)
    {
        $browser->script('Nova.$toasted.clear()');
    }

    /**
     * Close current dropdown.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     */
    public function closeCurrentDropdown(Browser $browser)
    {
        $browser->elsewhere('', function ($browser) {
            $overlay = $browser->element('[dusk="dropdown-overlay"]');

            if (! is_null($overlay) && $overlay->isDisplayed()) {
                $browser->click('@dropdown-overlay')->pause(250);
            }
        });
    }

    /**
     * Type on "date" input.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $selector
     * @param  \Carbon\CarbonInterface  $carbon
     * @return void
     */
    public function typeOnDate(Browser $browser, string $selector, CarbonInterface $carbon)
    {
        $browser->type($selector, $carbon->format(Env::get('DUSK_DATE_FORMAT', 'mdY')));
    }

    /**
     * Type on "datetime-local" input.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $selector
     * @param  \Carbon\CarbonInterface  $carbon
     * @return void
     */
    public function typeOnDateTimeLocal(Browser $browser, string $selector, CarbonInterface $carbon)
    {
        $browser->type($selector, $carbon->format(Env::get('DUSK_DATE_FORMAT', 'mdY')));
        $browser->keys($selector, ['{tab}']);
        $browser->type($selector, $carbon->format(Env::get('DUSK_TIME_FORMAT', 'hisa')));
    }

    /**
     * Assert active modal is present.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     */
    public function assertPresentModal(Browser $browser)
    {
        $browser->assertPresent('.modal[data-modal-open=true]');
    }

    /**
     * Assert active modal is missing.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     */
    public function assertMissingModal(Browser $browser)
    {
        $browser->assertMissing('.modal[data-modal-open=true]');
    }
}
