<?php

namespace App\Http\Controllers;

use App\Models\SRO\Shard\Char;
use App\Models\SRO\Shard\CharUniqueKill;
use App\Models\SRO\Shard\Guild;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function index()
    {
        $rankings = Char::paginate(25);
        return view('ranking.index', [
            'rankings' => $rankings,
        ]);
    }

    public function character_view($name)
    {
        $characters = Char::where('CharName16', $name)->first();
        if ($characters) {
            return view('ranking.character.index', [
                'characters' => $characters
            ]);
        }

        abort(404);
    }

    public function guild_view($name)
    {
        $guilds = Guild::where('Name', $name)->first();
        if ($guilds) {
            return view('ranking.guild.index', [
                'guilds' => $guilds
            ]);
        }

        abort(404);
    }

    public function player()
    {
        $players = Char::paginate(25);
        return view('ranking.ranking.player', [
            'players' => $players,
        ]);
    }

    public function guild()
    {
        $guilds = Guild::paginate(25);
        return view('ranking.ranking.guild', [
            'guilds' => $guilds,
        ]);
    }

    public function unique()
    {
        $uniques = CharUniqueKill::paginate(25);
        return view('ranking.ranking.unique', [
            'uniques' => $uniques,
        ]);
    }
}
