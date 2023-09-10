<?php

namespace Laravel\Nova\Testing\Browser\Components\Modals;

use Laravel\Dusk\Browser;

class PreviewResourceModalComponent extends ModalComponent
{
    /**
     * Modal confirmation button.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     */
    public function confirm(Browser $browser)
    {
        $browser->click('@confirm-preview-button');
    }

    /**
     * Modal cancelation button.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     */
    public function cancel(Browser $browser)
    {
        $browser->click('@confirm-preview-button');
    }

    /**
     * Modal view detail button.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     */
    public function view(Browser $browser)
    {
        $browser->click('@detail-preview-button');
    }

    /**
     * Assert modal view detail button is visible.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     */
    public function assertViewButtonVisible(Browser $browser)
    {
        $browser->assertVisible('@detail-preview-button');
    }
}
