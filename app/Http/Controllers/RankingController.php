<?php

namespace App\Http\Controllers;

use App\Models\SRO\Account\TbUser;
use App\Models\SRO\Portal\MuUser;
use App\Models\SRO\Shard\Char;
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

    public function player()
    {
        $rankings = Char::paginate(25);
        return view('ranking.player', [
            'rankings' => $rankings,
        ]);
    }

    public function guild()
    {
        $rankings = TbUser::paginate(25);
        return view('ranking.guild', [
            'rankings' => $rankings,
        ]);
    }

    public function unique()
    {
        $rankings = MuUser::paginate(25);
        return view('ranking.unique', [
            'rankings' => $rankings,
        ]);
    }
}
