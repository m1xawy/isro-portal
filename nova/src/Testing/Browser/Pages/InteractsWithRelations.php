<?php

namespace Laravel\Nova\Testing\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Nova\Testing\Browser\Components\Controls\RelationSelectControlComponent;
use Laravel\Nova\Testing\Browser\Concerns\InteractsWithInlineCreateRelation;

trait InteractsWithRelations
{
    use HasSearchable, InteractsWithInlineCreateRelation;

    /**
     * Select for the given value for a relationship attribute.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $attribute
     * @param  string|null  $value
     * @return void
     */
    public function selectRelation(Browser $browser, $attribute, $value = null)
    {
        $browser->whenAvailable(new RelationSelectControlComponent($attribute), function (Browser $browser) use ($value) {
            $browser->assertSelectHasOption('', $value)->select('', $value);
        });
    }

    /**
     * Search for the given value for a searchable relationship attribute.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $attribute
     * @param  string  $search
     * @return void
     */
    public function searchRelation(Browser $browser, $attribute, $search)
    {
        $this->searchInput($browser, $attribute, $search);
    }

    /**
     * Reset the searchable relationship attribute.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $attribute
     * @return void
     */
    public function resetSearchRelation(Browser $browser, $attribute)
    {
        $this->resetSearchResult($browser, $attribute);
    }

    /**
     * Select the currently highlighted searchable relation.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $attribute
     * @return void
     *
     * @deprecated
     */
    public function selectFirstRelation(Browser $browser, $attribute)
    {
        $this->selectFirstSearchResult($browser, $attribute);
    }

    /**
     * Select the currently highlighted searchable relation.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $attribute
     * @return void
     */
    public function firstSearchableResult(Browser $browser, $attribute)
    {
        $this->selectFirstSearchResult($browser, $attribute);
    }

    /**
     * Close the searchable relation result.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $attribute
     * @return void
     *
     * @deprecated
     */
    public function closeSearchableResult(Browser $browser, $attribute)
    {
        $this->cancelSelectingSearchResult($browser, $attribute);
    }

    /**
     * Search and select the currently highlighted searchable relation.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $attribute
     * @param  string  $search
     * @return void
     */
    public function searchFirstRelation(Browser $browser, $attribute, $search)
    {
        $this->searchAndSelectFirstResult($browser, $attribute, $search);
    }

    /**
     * Indicate that trashed relations should be included in the search results.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $resourceName
     * @return void
     */
    public function waitForTrashedRelation(Browser $browser, $resourceName)
    {
        $browser->waitFor("@{$resourceName}-with-trashed-checkbox", 5);
    }

    /**
     * Indicate that trashed relations should be included in the search results.
     */
    public function withTrashedRelation(Browser $browser, $resourceName)
    {
        $browser->waitForTrashedRelation($resourceName)->click('')->with(
            "@{$resourceName}-with-trashed-checkbox",
            function (Browser $browser) {
                $browser->waitFor('input[type="checkbox"]')
                    ->check('input[type="checkbox"]')
                    ->pause(250);
            }
        );
    }

    /**
     * Indicate that trashed relations should not be included in the search results.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $resourceName
     * @return void
     */
    public function withoutTrashedRelation(Browser $browser, $resourceName)
    {
        $browser->waitForTrashedRelation($resourceName)
            ->uncheck('[dusk="'.$resourceName.'-with-trashed-checkbox"] input[type="checkbox"]')
            ->pause(250);
    }
}
