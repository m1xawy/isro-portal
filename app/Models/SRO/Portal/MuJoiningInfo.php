<?php

namespace App\Models\SRO\Portal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MuJoiningInfo extends Model
{
    use HasFactory;

    protected $connection = 'portal';

    public $timestamps = false;

    protected $table = 'dbo.MU_JoiningInfo';

    protected $primaryKey = 'JID';

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
