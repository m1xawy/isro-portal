<?php

namespace App\Models\SRO\Shard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TradeEquipInventory extends Model
{
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
    protected $table = 'dbo._TradeEquipInventory';

    /**
     * The table primary Key
     *
     * @var string
     */
    protected $primaryKey = 'CharID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'CharID',
        'slot',
        'ItemID'
    ];

    public static function getInventoryForJob($characterId): array
    {
        return Cache::remember('MagOptDesc_'.$characterId, now()->addMinutes(config('settings.general.cache.data.character')), static function () use ($characterId) {
            return self::where('CharID', '=', $characterId)
            ->where('ItemID', '>', 1)
            ->join('_Items as Items', 'Items.ID64', 'ItemID')
            ->leftJoin('_BindingOptionWithItem as Binding', static function ($join) {
                $join->on('Binding.nItemDBID', 'Items.ID64');
                $join->where('Binding.nOptValue', '>', '0');
            })
            ->join('_RefObjCommon as Common', 'Items.RefItemId', 'Common.ID')
            ->join('_RefObjItem as ObjItem', 'Common.Link', 'ObjItem.ID')
            ->get()
            ->toArray();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getChar()
    {
        return $this->hasMany(Char::class, 'CharID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getItem()
    {
        return $this->belongsTo(Items::class, 'ItemID', 'ID64');
    }
}
