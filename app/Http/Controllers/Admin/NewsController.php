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
            'published_at' => 'required|date',
            'news_content' => 'required',
        ]);

        $validated['author_id'] = auth()->user()->id;
        $validated['title'] = preg_replace('/\s+/', ' ', trim($validated['title']));
        $validated['slug'] = Str::slug($validated['title']) . '-' . now()->timestamp;
        $validated['content'] = $validated['news_content'];

        News::create($validated);

        return redirect()->route('admin.news.index')->with('success', 'News created successfully!');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'category' => 'required',
            'published_at' => 'required',
            'news_content' => 'required',
        ]);

        $validated['title'] = preg_replace('/\s+/', ' ', trim($validated['title']));
        $validated['slug'] = Str::slug($validated['title']) . '-' . now()->timestamp;
        $validated['content'] = $validated['news_content'];
        $news->update($validated);

        return redirect()->route('admin.news.index')->with('success', 'News updated successfully.');
    }

    public function delete(News $news)
    {
        return view('admin.news.delete', compact('news'));
    }

    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'News deleted successfully.');
    }
}
