<?php

namespace App\Models\SRO\Shard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CharSkillMastery extends Model
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
    protected $table = 'dbo._CharSkillMastery';

    public static function getCharBuildInfo($CharID)
    {
        return Cache::remember('character_build_'.$CharID, now()->addMinutes(config('settings.general.cache.data.character')), function () use ($CharID) {
            return self::where('Level', '>', 0)->where('CharID', $CharID)->get();
        });
    }
}
