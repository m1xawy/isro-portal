<?php

namespace App\Http\Controllers;

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
}
