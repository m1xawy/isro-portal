<?php

namespace App\Http\Controllers;

use App\Models\SRO\Log\LogInstanceWorldInfo;
use App\Models\SRO\Shard\Char;
use App\Models\SRO\Shard\Guild;
use App\Services\InventoryService;
use Illuminate\Support\Facades\Cache;

class RankingController extends Controller
{
    public function index()
    {
        $data = Char::getPlayerRanking();
        return view('ranking.index', compact('data'));
    }

    public function player()
    {
        $data = Char::getPlayerRanking();
        return view('ranking.ranking.player', compact('data'));
    }

    public function guild()
    {
        $data = Guild::getGuildRanking();
        return view('ranking.ranking.guild', compact('data'));
    }

    public function unique()
    {
        $data = LogInstanceWorldInfo::getUniqueRanking();
        $unique_points = config('global.ranking.unique_points');
        return view('ranking.ranking.unique', [
            'data' => $data,
            'unique_points' => $unique_points,
        ]);
    }

    public function unique_monthly()
    {
        $data = LogInstanceWorldInfo::getUniqueRanking(25, 1);
        $unique_points = config('global.ranking.unique_points');
        return view('ranking.ranking.unique-monthly', [
            'data' => $data,
            'unique_points' => $unique_points,
        ]);
    }

    public function fortress_player()
    {
        $data = Char::getFortressPlayerRanking();
        return view('ranking.ranking.fortress-player', [
            'data' => $data,
        ]);
    }

    public function fortress_guild()
    {
        $data = Char::getFortressGuildRanking();
        return view('ranking.ranking.fortress-guild', [
            'data' => $data,
        ]);
    }

    public function honor()
    {
        $data = Char::getHonorRanking();
        return view('ranking.ranking.honor', [
            'data' => $data,
        ]);
    }

    public function job()
    {
        $data = Char::getJobRanking();
        return view('ranking.ranking.job', [
            'data' => $data,
        ]);
    }

    public function job_all()
    {
        $data = Char::getJobRanking();
        return view('ranking.ranking.job-all', [
            'data' => $data,
        ]);
    }

    public function job_trader()
    {
        $data = Char::getJobTraderRanking();
        return view('ranking.ranking.job-trader', [
            'data' => $data,
        ]);
    }

    public function job_hunter()
    {
        $data = Char::getJobHunterRanking();
        return view('ranking.ranking.job-hunter', [
            'data' => $data,
        ]);
    }

    public function job_thieve()
    {
        $data = Char::getJobThieveRanking();
        return view('ranking.ranking.job-thieve', [
            'data' => $data,
        ]);
    }

    public function character_view($name, InventoryService $inventoryService)
    {
        $charID = Char::select('CharID')->where('CharName16', $name)->first()->CharID ?? null;
        if ($charID > 0) {

            $characters = Char::getCharInfo($charID);
            $charUniqueHistory = Char::getCharUniqueHistory($charID) ?? [];
            $charGlobalHistory = Char::getCharGlobalHistory($name) ?? [];
            $charBuildInfo = Char::getCharBuildInfo($charID) ?? [];

            $playerInventory = cache()->remember('char_inventory_' . $name, setting('cache_info_char', 600), function() use ($inventoryService, $charID) {
                return $inventoryService->getInventorySet($charID, 13, 0);
            });

            $playerJobInventory = cache()->remember('char_inventory_job_' . $name, setting('cache_info_char', 600), function() use ($inventoryService, $charID) {
                return $inventoryService->getInventoryJob($charID);
            });

            $playerAvatar = cache()->remember('char_inventory_avatar_' . $name, setting('cache_info_char', 600), function() use ($inventoryService, $charID) {
                return $inventoryService->getInventoryAvatar($charID);
            });

            if ($characters) {
                return view('ranking.character.index', [
                    'characters' => $characters,
                    'charUniqueHistory' => $charUniqueHistory,
                    'charGlobalHistory' => $charGlobalHistory,
                    'charBuildInfo' => $charBuildInfo,
                    'playerInventory' => $playerInventory,
                    'playerJob' => $playerJobInventory,
                    'playerAvatar' => $playerAvatar
                ]);
            }
        }
        return redirect()->back();
    }

    public function guild_view($name)
    {
        $guildID = Guild::select('ID')->where('Name', $name)->first()->ID ?? null;

        if ($guildID > 0) {

            $guilds = (new Guild)->getGuildInfo($guildID);
            $guildMembers = (new Guild)->getGuildInfoMembers($guildID);
            $guildAlliances = (new Guild)->getGuildInfoAlliance($guildID);

            if ($guilds) {
                return view('ranking.guild.index', [
                    'guilds' => $guilds,
                    'guildMembers' => $guildMembers,
                    'guildAlliances' => $guildAlliances,
                ]);
            }
        }

        return redirect()->back();
    }

    public function guild_crest($hex)
    {
        if ($hex) {
            return drawGuildIconToPNG($hex);
        }

        abort(404);
    }
}
