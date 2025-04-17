<?php

namespace App\Models\SRO\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ShardCurrentUser extends Model
{
    use HasFactory;

    /**
     * The Database connection name for the model.
     *
     * @var string
     */
    protected $connection = 'account';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dbo._ShardCurrentUser';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
