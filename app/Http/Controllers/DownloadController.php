<?php

namespace App\Http\Controllers;

use App\Models\Download;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function index()
    {
        $downloads = cache()->remember('download', setting('cache_download', 600), function() {
            return Download::all();
        });

        return view('pages.download', [
            'downloads' => $downloads,
        ]);
    }
}
