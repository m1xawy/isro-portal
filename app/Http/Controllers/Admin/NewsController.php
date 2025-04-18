<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $data = News::get();
        return view('admin.news.index', compact('data'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'category' => 'required',
            'published_at' => 'required',
            'active' => 'required',
            'news_content' => 'required',
        ]);

        $validated['author_id'] = auth()->user()->id;
        $validated['slug'] = Str::slug($validated['title']) . '-' . now()->timestamp;
        $validated['content'] = $validated['news_content'];

        News::create($validated);

        return redirect()->route('admin.news.index')->with('success', 'News created successfully!');
    }

    public function destroy(News $post)
    {
        $post->delete();

        return redirect()->route('admin.news.index')->with('success', 'News deleted successfully.');
    }

    public function edit(News $post)
    {
        return view('admin.news.edit', compact('post'));
    }

    public function update(Request $request, News $post)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'category' => 'required',
            'published_at' => 'required',
            'active' => 'required',
            'news_content' => 'required',
        ]);

        $validated['content'] = $validated['news_content'];
        $post->update($validated);

        return redirect()->route('admin.news.index')->with('success', 'News updated successfully.');
    }
}
