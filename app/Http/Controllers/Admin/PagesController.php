<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pages;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Str;

class PagesController extends Controller
{
    public function index()
    {
        $data = Pages::get();
        return view('admin.pages.index', compact('data'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'pages_content' => 'required',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . now()->timestamp;
        $validated['content'] = $validated['pages_content'];

        Pages::create($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Pages created successfully!');
    }

    public function edit(Pages $pages)
    {
        return view('admin.pages.edit', compact('pages'));
    }

    public function update(Request $request, Pages $pages)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'pages_content' => 'required',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . now()->timestamp;
        $validated['content'] = $validated['pages_content'];

        $pages->update($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Pages updated successfully.');
    }

    public function delete(Pages $pages)
    {
        return view('admin.pages.delete', compact('pages'));
    }

    public function destroy(Pages $pages)
    {
        $pages->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Pages deleted successfully.');
    }
}
