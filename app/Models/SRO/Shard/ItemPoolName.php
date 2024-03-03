<?php

namespace App\Models\SRO\Shard;

use Illuminate\Database\Eloquent\Model;

class ItemPoolName extends Model
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
}
