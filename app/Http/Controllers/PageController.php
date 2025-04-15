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
        $posts = cache()->remember('posts', setting('cache_news', 600), function() {
            return Post::where('published_at', '<=', now())->orderBy('published_at', 'DESC')->get();
        });

        return view('pages.index', [
            'posts' => $posts,
        ]);
    }

    public function post($slug)
    {
        $post = cache()->remember('posts.view_'.$slug, setting('cache_news', 600), function() use ($slug) {
            return Post::where('slug', $slug)->first();
        });

        if ($post) {
            return view('pages.view', [
                'post' => $post
            ]);
        }

        return redirect()->back();
    }

    public function page($slug)
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
        $data = getServerTimes();

        return view('pages.timers', [
            'data' => $data,
        ]);
    }

    public function uniques()
    {
        $data = getFullUniqueHistory();
        $unique_names = getUniqueHistoryNamesCode();

        return view('pages.uniques', [
            'data' => $data,
            'unique_names' => $unique_names
        ]);
    }

    public function fortress()
    {
        $data = Char::getFortressHistoryRanking();

        return view('pages.fortress', [
            'data' => $data,
        ]);
    }

    public function globals()
    {
        $data = getGlobalHistory();

        return view('pages.globals', [
            'data' => $data,
        ]);
    }
}
