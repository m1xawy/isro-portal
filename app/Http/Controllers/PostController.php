<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $expire = now()->addSeconds(setting('cache_news', 60));
        $posts = cache()->remember('posts', $expire, function() {
            return Post::where('published_at', '<=', now())->get();
        });

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    public function show($slug)
    {
        $expire = now()->addSeconds(setting('cache_news', 60));
        $post = cache()->remember('posts.view', $expire, function() use ($slug) {
            return Post::where('slug', $slug)->first();
        });

        if ($post) {
            return view('posts.view', [
                'post' => $post
            ]);
        }

        abort(404);
    }
}
