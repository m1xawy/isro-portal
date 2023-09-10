<?php

namespace Laravel\Nova\Testing\Browser\Components\Modals;

use Laravel\Dusk\Browser;

class ConfirmActionModalComponent extends ModalComponent
{
    /**
     * Modal confirmation button.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     */
    public function confirm(Browser $browser)
    {
        $browser->click('@confirm-action-button');
    }

    /**
     * Modal cancelation button.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     */
    public function cancel(Browser $browser)
    {
        $browser->click('@cancel-action-button');
    }
}
