<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $data = Post::get();
        return view('admin.posts.index', compact('data'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'slug' => 'unique:posts|string',
            'news_content' => 'required',
            'published_at' => 'required',
            'category' => 'required',
        ]);

        Post::create([
            'author_id' => auth()->user()->id,
            'title' => $request->title,
            'slug' => Str::slug($request->slug,'-'),
            'content' => $request->news_content,
            'published_at' => $request->published_at,
            'category' => $request->category,
        ]);

        return redirect()->route('admin.news.index')->with('success', 'News created successfully!');
    }
}
