<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    public function index()
    {
        $data = "Test from news controller";
        return view('admin.posts.index', compact('data'));
    }
}
