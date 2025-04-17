<?php

namespace App\Models\SRO\Portal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MuJoiningInfo extends Model
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
    protected $table = 'dbo.MU_JoiningInfo';

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
        'UserIP',
        'JoiningDate',
        'CountryCode',
        'JoiningPath'
    ];

    public static function setJoiningInfo($jid, $bip)
    {
        return self::create([
            'JID' => $jid,
            'UserIP' => $bip,
            'JoiningDate' => now(),
            'CountryCode' => 'EG',
            'JoiningPath' => 'JOYMAX'
        ]);
    }
}
