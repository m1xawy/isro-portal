<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\News;
use App\Models\SRO\Log\LogChatMessage;
use App\Models\SRO\Log\LogEventSiegeFortress;
use App\Models\SRO\Log\LogInstanceWorldInfo;
use App\Services\ScheduleService;
use Illuminate\Support\Facades\Cache;
use Outl1ne\PageManager\Helpers\NPMHelpers;

class PageController extends Controller
{
    public function index()
    {
        $data = News::getPosts();
        return view('pages.index', compact('data'));
    }

    public function post($slug)
    {
        $data = News::getPost($slug);
        if (!$data) {
            return redirect()->back();
        }

        return view('pages.view', compact('data'));
    }

    public function page($slug)
    {
        $data = Cache::remember('page_view_'.$slug, now()->addMinutes(config('global.general.cache.data.pages')), function () use ($slug) {
            foreach (NPMHelpers::getPages() as $value){
                if (!$value['slug']['en'] == $slug) {
                    return redirect()->back();
                }
                $page = $value;
            }
            return $page;
        });

        return view('pages.page', compact('data'));
    }

    public function download()
    {
        $data = Download::getDownloads();
        return view('pages.download', compact('data'));
    }

    public function timers(ScheduleService $scheduleService)
    {
        $data = $scheduleService->getEventSchedules();
        return view('pages.timers', compact('data'));
    }

    public function uniques()
    {
        $data = LogInstanceWorldInfo::getUniques();
        return view('pages.uniques', compact('data'));
    }

    public function fortress()
    {
        $data = LogEventSiegeFortress::getFortressHistory(25);
        return view('pages.fortress', compact('data'));
    }

    public function globals()
    {
        $data = LogChatMessage::getGlobalsHistory(25);
        return view('pages.globals', compact('data'));
    }
}
