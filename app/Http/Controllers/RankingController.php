<?php

namespace App\Http\Controllers;

use App\Http\Services\InventoryService;
use App\Models\SRO\Shard\Char;
use App\Models\SRO\Shard\Guild;

class RankingController extends Controller
{
    public function index()
    {
        $rankings = Char::getPlayerRanking();
        return view('ranking.index', [
            'data' => $rankings,
        ]);
    }

    public function player()
    {
        $players = Char::getPlayerRanking();
        return view('ranking.ranking.player', [
            'data' => $players,
        ]);
    }

    public function guild()
    {
        $guilds = Char::getGuildRanking();
        return view('ranking.ranking.guild', [
            'data' => $guilds,
        ]);
    }

    public function unique()
    {
        $unique_list_settings = cache()->remember('ranking_unique_list', setting('cache_ranking_unique', 600), function() { return json_decode(setting('ranking_unique_list')); });
        if(!empty($unique_list_settings)) {
            $uniques = Char::getUniqueRanking();
            $unique_lists = $unique_list_settings;
        } else {
            $uniques = [];
            $unique_lists = [];
        }

        return view('ranking.ranking.unique', [
            'data' => $uniques,
            'unique_lists' => $unique_lists,
        ]);
    }

    public function unique_monthly()
    {
        $unique_list_settings = cache()->remember('ranking_unique_monthly_list', setting('cache_ranking_unique', 600), function() { return json_decode(setting('ranking_unique_list')); });
        if(!empty($unique_list_settings)) {
            $uniquesMonthly = Char::getUniqueMonthlyRanking();
            $unique_lists = $unique_list_settings;
        } else {
            $uniquesMonthly = [];
            $unique_lists = [];
        }

        return view('ranking.ranking.unique-monthly', [
            'data' => $uniquesMonthly,
            'unique_lists' => $unique_lists,
        ]);
    }

    public function fortress_player()
    {
        $fortressPlayer = Char::getFortressPlayerRanking();

        return view('ranking.ranking.fortress-player', [
            'data' => $fortressPlayer,
        ]);
    }

    public function fortress_guild()
    {
        $fortressGuild = Char::getFortressGuildRanking();

        return view('ranking.ranking.fortress-guild', [
            'data' => $fortressGuild,
        ]);
    }

    public function honor()
    {
        $honor = Char::getHonorRanking();

        return view('ranking.ranking.honor', [
            'data' => $honor,
        ]);
    }

    public function job()
    {
        $job = Char::getJobRanking();

        return view('ranking.ranking.job', [
            'data' => $job,
        ]);
    }

    public function job_all()
    {
        $jobAll = Char::getJobRanking();

        return view('ranking.ranking.job-all', [
            'data' => $jobAll,
        ]);
    }

    public function job_trader()
    {
        $jobTrader = Char::getJobTraderRanking();

        return view('ranking.ranking.job-trader', [
            'data' => $jobTrader,
        ]);
    }

    public function job_hunter()
    {
        $jobHunter = Char::getJobHunterRanking();

        return view('ranking.ranking.job-hunter', [
            'data' => $jobHunter,
        ]);
    }

    public function job_thieve()
    {
        $jobThieve = Char::getJobThieveRanking();

        return view('ranking.ranking.job-thieve', [
            'data' => $jobThieve,
        ]);
    }

    public function character_view($name, InventoryService $inventoryService)
    {
        $charID = Char::select('CharID')->where('CharName16', $name)->first()->CharID ?? null;

        if ($charID > 0) {

            $characters = (new Char)->getCharInfo($charID);
            $charUniqueHistory = (new Char)->getCharUniqueHistory($charID);
            $charGlobalHistory = (new Char)->getCharGlobalHistory($name);
            $charBuildInfo = (new Char)->getCharBuildInfo($charID);

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
