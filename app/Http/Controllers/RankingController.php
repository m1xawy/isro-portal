<?php

namespace App\Http\Controllers;

use App\Models\SRO\Shard\Char;
use App\Models\SRO\Shard\CharUniqueKill;
use App\Models\SRO\Shard\Guild;
use Illuminate\Http\Request;
use App\Http\Services\SRO\Shard\InventoryService;

class RankingController extends Controller
{
    public function index()
    {
        $rankings = (new Char)->getPlayerRanking();
        return view('ranking.index', [
            'rankings' => $rankings,
        ]);
    }

    public function player()
    {
        $players = (new Char)->getPlayerRanking();
        return view('ranking.ranking.player', [
            'players' => $players,
        ]);
    }

    public function guild()
    {
        $guilds = (new Char)->getGuildRanking();
        return view('ranking.ranking.guild', [
            'guilds' => $guilds,
        ]);
    }

    public function unique()
    {
        $unique_list_settings = cache()->remember('ranking_unique_list', setting('cache_ranking_unique', 600), function() { return json_decode(setting('ranking_unique_list')); });
        if(!empty($unique_list_settings)) {
            $uniques = (new Char)->getUniqueRanking();
            $unique_lists = $unique_list_settings;
        } else {
            $uniques = [];
            $unique_lists = [];
        }

        return view('ranking.ranking.unique', [
            'uniques' => $uniques,
            'unique_lists' => $unique_lists,
        ]);
    }

    public function unique_monthly()
    {
        $unique_list_settings = cache()->remember('ranking_unique_monthly_list', setting('cache_ranking_unique', 600), function() { return json_decode(setting('ranking_unique_list')); });
        if(!empty($unique_list_settings)) {
            $uniquesMonthly = (new Char)->getUniqueMonthlyRanking();
            $unique_lists = $unique_list_settings;
        } else {
            $uniques = [];
            $unique_lists = [];
        }

        return view('ranking.ranking.unique-monthly', [
            'uniques' => $uniquesMonthly,
            'unique_lists' => $unique_lists,
        ]);
    }

    public function fortress_player()
    {
        $fortressPlayer = (new Char)->getFortressPlayerRanking();

        return view('ranking.ranking.fortress-player', [
            'fortressPlayers' => $fortressPlayer,
        ]);
    }

    public function fortress_guild()
    {
        $fortressGuild = (new Char)->getFortressGuildRanking();

        return view('ranking.ranking.fortress-guild', [
            'fortressGuilds' => $fortressGuild,
        ]);
    }

    public function honor()
    {
        $honor = (new Char)->getHonorRanking();

        return view('ranking.ranking.honor', [
            'honor' => $honor,
        ]);
    }

    public function job()
    {
        $job = (new Char)->getJobRanking();

        return view('ranking.ranking.job', [
            'job' => $job,
        ]);
    }

    public function job_all()
    {
        $jobAll = (new Char)->getJobRanking();

        return view('ranking.ranking.job-all', [
            'jobAll' => $jobAll,
        ]);
    }

    public function job_trader()
    {
        $jobTrader = (new Char)->getJobTraderRanking();

        return view('ranking.ranking.job-trader', [
            'jobTrader' => $jobTrader,
        ]);
    }

    public function job_hunter()
    {
        $jobHunter = (new Char)->getJobHunterRanking();

        return view('ranking.ranking.job-hunter', [
            'jobHunter' => $jobHunter,
        ]);
    }

    public function job_thieve()
    {
        $jobThieve = (new Char)->getJobThieveRanking();

        return view('ranking.ranking.job-thieve', [
            'jobThieve' => $jobThieve,
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
