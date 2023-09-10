<?php

namespace Laravel\Nova\Testing\Browser\Components\Modals;

use Laravel\Dusk\Browser;

class CreateRelationModalComponent extends ModalComponent
{
    /**
     * Modal confirmation button.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     */
    public function confirm(Browser $browser)
    {
        $browser->click('@create-button');
    }

    /**
     * Modal cancelation button.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     */
    public function cancel(Browser $browser)
    {
        $browser->click('@cancel-create-button');
    }
}
