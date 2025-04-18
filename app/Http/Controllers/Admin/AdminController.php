<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SRO\Portal\AphChangedSilk;
use App\Models\SRO\Shard\Char;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $data = "Test from admin controller";
        $userCount = User::getUserCount();
        $charCount = Char::getCharCount();
        $totalGold = Char::getGoldSum();
        //$totalSilk = AphChangedSilk::getSilkSum();
        $totalSilk = 'Unknown';

        return view('admin.index', [
            'data' => $data,
            'userCount' => $userCount,
            'charCount' => $charCount,
            'totalGold' => $totalGold,
            'totalSilk' => $totalSilk,
        ]);
    }
}
