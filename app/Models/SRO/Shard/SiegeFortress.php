<?php

namespace App\Models\SRO\Shard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiegeFortress extends Model
{
    use HasFactory;

    protected $connection = 'shard';

    protected $table = 'dbo._SiegeFortress';

    protected $primaryKey = 'FortressID';

    protected $fillable = [];

    protected $dates = [
        'CreatedDungeonTime'
    ];

    protected $dateFormat = 'Y-m-d H:i:s';

    public static function getFortress()
    {
        return Cache::remember('fortress_war_widget', now()->addMinutes(config('global.general.cache.data.fortress_war')), function () {
            return self::select(["FortressID", "GuildID", "TaxRatio", "_Guild.Name"])
                ->join("_Guild", "_SiegeFortress.GuildID", "=", "_Guild.ID")
                ->get();
        });
    }

    public function getGuildName()
    {
        $query = $this->hasOne(Guild::class, 'ID', 'GuildID');
        $query->where('ID', '!=', 0);
        return $query;
    }
}
