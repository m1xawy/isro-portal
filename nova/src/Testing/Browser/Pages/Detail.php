<?php

namespace Laravel\Nova\Testing\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Nova\Testing\Browser\Components\ActionDropdownComponent;
use Laravel\Nova\Testing\Browser\Components\IndexComponent;
use Laravel\Nova\Testing\Browser\Components\Modals\DeleteResourceModalComponent;
use Laravel\Nova\Testing\Browser\Components\Modals\RestoreResourceModalComponent;

class Detail extends Page
{
    public $resourceName;

    public $resourceId;

    /**
     * Create a new page instance.
     *
     * @param  string  $resourceName
     * @param  string  $resourceId
     * @return void
     */
    public function __construct($resourceName, $resourceId)
    {
        $this->resourceId = $resourceId;
        $this->resourceName = $resourceName;

        $this->setNovaPage("/resources/{$this->resourceName}/{$this->resourceId}");
    }

    /**
     * Run the action with the given URI key.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $uriKey
     * @return void
     *
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function runAction(Browser $browser, $uriKey)
    {
        $browser->openControlSelector()
            ->elsewhereWhenAvailable(new ActionDropdownComponent(), function ($browser) use ($uriKey) {
                $browser->runWithConfirmation($uriKey);
            });
    }

    /**
     * Run the action with the given URI key.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $uriKey
     * @return void
     *
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function runInstantAction(Browser $browser, $uriKey)
    {
        $browser->openControlSelector()
            ->elsewhereWhenAvailable(new ActionDropdownComponent(), function ($browser) use ($uriKey) {
                $browser->runWithoutConfirmation($uriKey);
            });
    }

    /**
     * Open the action modal but cancel the action.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $uriKey
     * @return void
     *
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function cancelAction(Browser $browser, $uriKey)
    {
        $browser->openControlSelector()
            ->elsewhereWhenAvailable(new ActionDropdownComponent(), function ($browser) use ($uriKey) {
                $browser->cancel($uriKey);
            });
    }

    /**
     * Edit the resource.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     *
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function edit(Browser $browser)
    {
        $browser->waitFor('@edit-resource-button')
            ->click('@edit-resource-button');
    }

    /**
     * Create the related resource.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $relatedResourceName
     * @return void
     *
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function runCreateRelation(Browser $browser, $relatedResourceName)
    {
        $browser->within(new IndexComponent($relatedResourceName), function ($browser) {
            $browser->waitFor('@create-button')->click('@create-button');
        })->on(new Create($relatedResourceName));
    }

    /**
     * Create the related resource.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $relatedResourceName
     * @param  string|null  $viaRelationship
     * @return void
     *
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function runAttachRelation(Browser $browser, $relatedResourceName, $viaRelationship = null)
    {
        $browser->within(new IndexComponent($relatedResourceName, $viaRelationship), function ($browser) {
            $browser->waitFor('@attach-button')->click('@attach-button');
        })->on(new Attach($this->resourceName, $this->resourceId, $relatedResourceName, $viaRelationship));
    }

    /**
     * Open the delete selector.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     *
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function openControlSelector(Browser $browser)
    {
        $browser->whenAvailable("@{$this->resourceId}-control-selector", function ($browser) {
            $browser->click('');
        })->pause(100);
    }

    /**
     * Replicate the resource.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     *
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function replicate(Browser $browser)
    {
        $browser->openControlSelector()
            ->whenAvailable("@{$this->resourceId}-replicate-button", function ($browser) {
                $browser->click('');
            });
    }

    /**
     * Delete the resource.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     *
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function delete(Browser $browser)
    {
        $browser->openControlSelector()
            ->whenAvailable('@open-delete-modal-button', function ($browser) {
                $browser->click('');
            })
            ->elsewhereWhenAvailable(new DeleteResourceModalComponent(), function ($browser) {
                $browser->confirm();
            })->pause(1000);
    }

    /**
     * Restore the resource.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     *
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function restore(Browser $browser)
    {
        $browser->openControlSelector()
            ->whenAvailable('@open-restore-modal-button', function ($browser) {
                $browser->click('');
            })
            ->elsewhereWhenAvailable(new RestoreResourceModalComponent(), function ($browser) {
                $browser->confirm();
            })->pause(1000);
    }

    /**
     * Force delete the resource.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     *
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function forceDelete(Browser $browser)
    {
        $browser->openControlSelector()
            ->whenAvailable('@open-force-delete-modal-button', function ($browser) {
                $browser->click('');
            })
            ->elsewhereWhenAvailable(new DeleteResourceModalComponent(), function ($browser) {
                $browser->confirm();
            })->pause(1000);
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertOk()->waitFor('@nova-resource-detail');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@nova-resource-detail' => '#app [data-testid="content"] [dusk="'.$this->resourceName.'-detail-component"]',
        ];
    }
}
