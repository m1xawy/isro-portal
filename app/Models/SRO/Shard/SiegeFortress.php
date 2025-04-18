<?php

namespace App\Models\SRO\Shard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiegeFortress extends Model
{
    use HasFactory;

    /**
     * The Database connection name for the model.
     *
     * @var string
     */
    protected $connection = 'shard';

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
    protected $table = 'dbo._SiegeFortress';

    /**
     * The table primary Key
     *
     * @var string
     */
    protected $primaryKey = 'FortressID';

    /**
     * The attributes format for dates.
     *
     * @var array
     */
    protected $dates = [
        'CreatedDungeonTime'
    ];

    protected $dateFormat = 'Y-m-d H:i:s';

    public static function getFortress()
    {
        return Cache::remember('fortress_war_widget', now()->addMinutes(config('settings.general.cache.data.fortress_war')), function () {
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
