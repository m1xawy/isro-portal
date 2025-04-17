<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        $data = "Test from admin controller";
        return view('admin.index', compact('data'));
    }
}
