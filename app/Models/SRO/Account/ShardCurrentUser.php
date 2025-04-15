<?php

namespace App\Models\SRO\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ShardCurrentUser extends Model
{
    use HasFactory;

    protected $connection = 'account';

    public $timestamps = false;

    protected $table = 'dbo._ShardCurrentUser';

    protected $fillable = [];

    public static function getOnlineCounter()
    {
        return Cache::remember('online_counter', now()->addMinutes(config('global.general.cache.data.online_counter')), function () {
            return self::select("nUserCount")
                ->orderBy("nID", "desc")
                ->take(1)
                ->get()
                ->value("nUserCount");
        });
    }
}
