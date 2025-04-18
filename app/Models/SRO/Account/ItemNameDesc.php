<?php

namespace App\Models\SRO\Account;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ItemNameDesc extends Model
{
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
    protected $table = 'dbo._Rigid_ItemNameDesc';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Service',
        'ID',
        'StrID',
        'KOR',
        'UNK0',
        'UNK1',
        'UNK2',
        'UNK3',
        'VNM',
        'ENG',
        'UNK4',
        'UNK5',
        'UNK6',
        'TUR',
        'ARA',
        'ESP',
        'GER'
    ];

    public static function getItemRealName($CodeName128): string
    {
        $mappingList = Cache::remember('ItemNameDesc_'.$CodeName128, now()->addMinutes(config('settings.general.cache.data.character')), static function () {
            $q = self::all();

            $aList = [];
            foreach ($q as $iKey => $aCurData) {
                $aList[$aCurData['StrID']] = [
                    'realName' => $aCurData['ENG'],
                    'codeName' => $aCurData['StrID']
                ];
            }
            return $aList;
        });

        if (array_key_exists($CodeName128, $mappingList)) {
            return $mappingList[$CodeName128]['realName'];
        }

        return $CodeName128;
    }
}
