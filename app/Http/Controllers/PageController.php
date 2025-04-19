<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\News;
use App\Models\Pages;
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
        $data = Pages::getPage($slug);
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

    public function uniques_advanced()
    {
        $data = LogInstanceWorldInfo::getUniques(9999, 0);
        $data_ranking = LogInstanceWorldInfo::getUniqueRanking(9999, 0);
        $unique_list = config('settings.ranking.unique_points');

        foreach ($data as $value) {
            $data_adv[$value->Value][] = $value;
        }

        foreach ($data_ranking as $value) {
            $data_rank[$value->CharName16][] = $value;
        }

        return view('pages.uniques-advanced', [
            'data' => $data_adv,
            'data_rank' => $data_rank,
            'unique_list' => $unique_list,
        ]);
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
