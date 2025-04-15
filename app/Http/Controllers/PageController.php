<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\Post;
use App\Models\SRO\Shard\Char;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Outl1ne\PageManager\Helpers\NPMHelpers;

class PageController extends Controller
{
    public function index()
    {
        $data = Cache::remember('news', config('global.general.cache.data.news'), function () {
            return Post::where('published_at', '<=', now())->orderBy('published_at', 'DESC')->get();
        });

        return view('pages.index', [
            'data' => $data,
        ]);
    }

    public function post($slug)
    {
        $data = Cache::remember('news_view_'.$slug, config('global.general.cache.data.news'), function () use ($slug) {
            return Post::where('slug', $slug)->first();
        });

        if ($data) {
            return view('pages.view', [
                'post' => $data
            ]);
        }

        return redirect()->back();
    }

    public function page($slug)
    {
        $data = Cache::remember('page_view_'.$slug, config('global.general.cache.data.pages'), function () use ($slug) {
            return NPMHelpers::getPages();
        });

        foreach ($data as $value){
            if ($value['slug']['en'] == $slug) {
                $data = $value;
            } else {
                return redirect()->back();
            }
        }

        return view('pages.page', [
            'data' => $data,
        ]);
    }

    public function download()
    {
        $data = Cache::remember('download', config('global.general.cache.data.download'), function () {
            return Download::all();
        });

        return view('pages.download', [
            'data' => $data,
        ]);
    }

    public function timers()
    {
        $data = Cache::remember('event-schedule', config('global.general.cache.data.event-schedule'), function () {
            return getServerTimes();
        });

        return view('pages.timers', [
            'data' => $data,
        ]);
    }

    public function uniques()
    {
        $data = Cache::remember('unique-history', config('global.general.cache.data.unique-history'), function () {
            return getFullUniqueHistory();
        });

        if (!$data) {
            $data = [];
        }

        return view('pages.uniques', [
            'data' => $data,
        ]);
    }

    public function fortress()
    {
        $data = Cache::remember('fortress-war', config('global.general.cache.data.fortress-war'), function () {
            return Char::getFortressHistoryRanking();
        });

        return view('pages.fortress', [
            'data' => $data,
        ]);
    }

    public function globals()
    {
        $data = Cache::remember('global-history', config('global.general.cache.data.global-history'), function () {
            return getGlobalHistory();
        });

        return view('pages.globals', [
            'data' => $data,
        ]);
    }
}
