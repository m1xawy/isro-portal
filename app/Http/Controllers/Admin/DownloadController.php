<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Str;

class DownloadController extends Controller
{
    public function index()
    {
        $data = Download::get();
        return view('admin.download.index', compact('data'));
    }

    public function create()
    {
        return view('admin.download.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'desc' => 'required|string',
            'url' => 'required|url',
            'icon' => 'string',
        ]);

        Download::create($validated);

        return redirect()->route('admin.download.index')->with('success', 'Download created successfully!');
    }

    public function edit(Download $download)
    {
        return view('admin.download.edit', compact('download'));
    }

    public function update(Request $request, Download $download)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'desc' => 'required|string',
            'url' => 'required|url',
            'icon' => 'string',
        ]);

        $download->update($validated);

        return redirect()->route('admin.download.index')->with('success', 'Download updated successfully.');
    }

    public function delete(Download $download)
    {
        return view('admin.download.delete', compact('download'));
    }

    public function destroy(Download $download)
    {
        $download->delete();

        return redirect()->route('admin.download.index')->with('success', 'Download deleted successfully.');
    }
}
