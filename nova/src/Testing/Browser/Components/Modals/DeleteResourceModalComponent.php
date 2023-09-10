<?php

namespace Laravel\Nova\Testing\Browser\Components\Modals;

use Laravel\Dusk\Browser;

class DeleteResourceModalComponent extends ModalComponent
{
    /**
     * Modal confirmation button.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     */
    public function confirm(Browser $browser)
    {
        $browser->click('@confirm-delete-button');
    }

    /**
     * Modal cancelation button.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     */
    public function cancel(Browser $browser)
    {
        $browser->click('@cancel-delete-button');
    }
}
