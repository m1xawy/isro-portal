<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Outl1ne\PageManager\Helpers\NPMHelpers;

class PageController extends Controller
{
    public function show($slug)
    {
        $pages = cache()->remember('page', setting('cache_page', 600), function() {
            return NPMHelpers::getPages();
        });

        foreach ($pages as $page){
            if ($page['slug']['en'] == $slug) {
                return view('pages.page', [
                    'page' => $page,
                ]);
            }
        }

        return redirect()->back();
    }

    public function timers()
    {
        $timers = cache()->remember('page_timers', setting('cache_page', 600), function() {
            return getServerTimes();
        });

        return view('pages.timers', [
            'timers' => $timers,
        ]);
    }

    public function uniques()
    {
        $uniques = cache()->remember('page_uniques', setting('cache_page', 600), function() {
            return getFullUniqueHistory();
        });

        $uniques_name = cache()->remember('page_uniques_name', setting('cache_page', 600), function() {
            return getUniqueHistoryNamesCode();
        });

        return view('pages.uniques', [
            'uniques' => $uniques,
            'uniques_name' => $uniques_name
        ]);
    }
}
