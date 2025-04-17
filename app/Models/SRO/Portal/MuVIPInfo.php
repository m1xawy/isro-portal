<?php

namespace App\Models\SRO\Portal;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MuVIPInfo extends Model
{
    use HasFactory;

    /**
     * The Database connection name for the model.
     *
     * @var string
     */
    protected $connection = 'portal';

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
    protected $table = 'dbo.MU_VIP_Info';

    /**
     * The table primary Key
     *
     * @var string
     */
    protected $primaryKey = 'JID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'JID',
        'VIPUserType',
        'VIPLv',
        'UpdateDate',
        'ExpireDate'
    ];

    public static function setVIPInfo($jid)
    {
        return self::create([
            'JID' => $jid,
            'VIPUserType' => 2,
            'VIPLv' => 1,
            'UpdateDate' => now(),
            'ExpireDate' => now()->addMonths(1),
        ]);
    }
}
