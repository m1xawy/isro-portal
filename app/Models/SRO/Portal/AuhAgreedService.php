<?php

namespace App\Models\SRO\Portal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuhAgreedService extends Model
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
    protected $table = 'dbo.AUH_AgreedService';

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
        'ServiceCode',
        'StartDate',
        'EndDate',
        'UserIP'
    ];

    public static function setAgreedService($jid, $bip)
    {
        return self::create([
            'JID' => $jid,
            'ServiceCode' => 2,
            'StartDate' => now(),
            'EndDate' => '9999-12-31 00:00:00',
            'UserIP' => $bip
        ]);
    }
}
