<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = cache()->remember('posts', setting('cache_news', 600), function() {
            return Post::where('published_at', '<=', now())->get();
        });

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    public function show($slug)
    {
        $post = cache()->remember('posts.view', setting('cache_news', 600), function() use ($slug) {
            return Post::where('slug', $slug)->first();
        });

        if ($post) {
            return view('posts.view', [
                'post' => $post
            ]);
        }

        return redirect()->back();
    }
}
