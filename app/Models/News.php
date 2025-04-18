<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'content',
        'published_at',
        'category',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            if ( !$post->author_id ) {
                $post->author_id = Auth::id();
            }
        });
    }

    public static function getPosts()
    {
        return Cache::remember('news', now()->addMinutes(config('global.general.cache.data.news')), function () {
            return self::where('active', '=', 1)->where('published_at', '<=', now())->orderBy('created_at', 'DESC')->get();
        });
    }

    public static function getPost($slug)
    {
        return Cache::remember('news_view_'.$slug, now()->addMinutes(config('global.general.cache.data.news')), function () use ($slug) {
            return self::where('slug', $slug)->first();
        });
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
