<?php

namespace Laravel\Nova\Testing\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Nova\Testing\Browser\Components\SearchInputComponent;

trait HasSearchable
{
    /**
     * Search for the given value for a searchable field attribute.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $attribute
     * @param  string  $search
     * @return void
     */
    public function searchInput(Browser $browser, $attribute, $search)
    {
        $browser->whenAvailable(new SearchInputComponent($attribute), function ($browser) use ($search) {
            $browser->searchInput($search);
        });
    }

    /**
     * Reset the searchable field.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $attribute
     * @param  int  $resultIndex
     * @return void
     */
    public function resetSearchResult(Browser $browser, $attribute)
    {
        $browser->whenAvailable(new SearchInputComponent($attribute), function ($browser) {
            $browser->resetSearchResult();
        });
    }

    /**
     * Select the searchable field by result index.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $attribute
     * @param  int  $resultIndex
     * @return void
     */
    public function selectSearchResult(Browser $browser, $attribute, $resultIndex)
    {
        $browser->whenAvailable(new SearchInputComponent($attribute), function ($browser) use ($resultIndex) {
            $browser->selectSearchResult($resultIndex);
        });
    }

    /**
     * Select the currently highlighted searchable field.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $attribute
     * @return void
     */
    public function selectFirstSearchResult(Browser $browser, $attribute)
    {
        $this->selectSearchResult($browser, $attribute, 0);
    }

    /**
     * Select the currently highlighted searchable field.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $attribute
     * @return void
     */
    public function cancelSelectingSearchResult(Browser $browser, $attribute)
    {
        $browser->whenAvailable(new SearchInputComponent($attribute), function ($browser) {
            $browser->cancelSelectingSearchResult();
        });
    }

    /**
     * Search and select the searchable field by result index.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $attribute
     * @param  string  $search
     * @param  int  $resultIndex
     * @return void
     */
    public function searchAndSelectResult(Browser $browser, $attribute, $search, $resultIndex)
    {
        $browser->whenAvailable(new SearchInputComponent($attribute), function ($browser) use ($search, $resultIndex) {
            $browser->searchAndSelectResult($search, $resultIndex);
        });
    }

    /**
     * Search and select the currently highlighted searchable field.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $attribute
     * @param  string  $search
     * @return void
     */
    public function searchAndSelectFirstResult(Browser $browser, $attribute, $search)
    {
        $this->searchAndSelectResult($browser, $attribute, $search, 0);
    }

    /**
     * Assert on searchable results.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $attribute
     * @param  callable(\Laravel\Nova\Browser, string):void  $fieldCallback
     * @return void
     */
    public function assertSearchResult(Browser $browser, $attribute, callable $fieldCallback)
    {
        $browser->whenAvailable(new SearchInputComponent($attribute), function ($browser) use ($fieldCallback) {
            $browser->assertSearchResult($search, $fieldCallback);
        });
    }

    /**
     * Assert on searchable results current value.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $attribute
     * @param  string  $search
     * @return void
     */
    public function assertSelectedSearchResult(Browser $browser, $attribute, $search)
    {
        $browser->whenAvailable(new SearchInputComponent($attribute), function ($browser) use ($search) {
            $browser->assertSelectedSearchResult($search);
        });
    }

    /**
     * Assert on searchable results is locked to single result.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $attribute
     * @param  string  $search
     * @return void
     */
    public function assertSelectedFirstSearchResult(Browser $browser, $attribute, $search)
    {
        $browser->whenAvailable(new SearchInputComponent($attribute), function ($browser) use ($search) {
            $browser->assertSelectedFirstSearchResult($search);
        });
    }

    /**
     * Assert on searchable results is empty.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $attribute
     * @return void
     */
    public function assertEmptySearchResult(Browser $browser, $attribute)
    {
        $browser->whenAvailable(new SearchInputComponent($attribute), function ($browser) {
            $browser->assertEmptySearchResult();
        });
    }

    /**
     * Assert on searchable results has the search value.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $attribute
     * @param  string|array  $search
     * @return void
     *
     * @deprecated
     */
    public function assertSearchResultHas(Browser $browser, $attribute, $search)
    {
        $this->assertSearchResultContains($browser, $attribute, $search);
    }

    /**
     * Assert on searchable results has the search value.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $attribute
     * @param  string|array  $search
     * @return void
     */
    public function assertSearchResultContains(Browser $browser, $attribute, $search)
    {
        $browser->whenAvailable(new SearchInputComponent($attribute), function ($browser) use ($search) {
            $browser->assertSearchResultContains($search);
        });
    }

    /**
     * Assert on searchable results doesn't has the search value.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $attribute
     * @param  string|array  $search
     * @return void
     */
    public function assertSearchResultDoesNotContains(Browser $browser, $attribute, $search)
    {
        $browser->whenAvailable(new SearchInputComponent($attribute), function ($browser) use ($search) {
            $browser->assertSearchResultDoesNotContains($search);
        });
    }
}
