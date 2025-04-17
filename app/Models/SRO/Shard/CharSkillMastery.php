<?php

namespace App\Models\SRO\Shard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CharSkillMastery extends Model
{
    use HasFactory;

    protected $connection = 'shard';

    public $timestamps = false;

    protected $table = 'dbo._CharSkillMastery';

    public static function getCharBuildInfo($CharID)
    {
        return Cache::remember('character_build_'.$CharID, now()->addMinutes(config('global.general.cache.data.character')), function () use ($CharID) {
            return self::where('Level', '>', 0)->where('CharID', $CharID)->get();
        });
    }
}
