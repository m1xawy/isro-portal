<?php

namespace App\Models\SRO\Portal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MuhAlteredInfo extends Model
{
    use HasFactory;

    protected $connection = 'portal';

    public $timestamps = false;

    protected $table = 'dbo.MUH_AlteredInfo';

    //protected $primaryKey = 'JID';

    protected $fillable = [
        'JID',
        'AlterationDate',
        'LastName',
        'FirstName',
        'EmailAddr',
        'EmailReceptionStatus',
        'EmailCertificationStatus',
        'UserIP',
        'CountryCode',
        'NickName',
        'ATypeCode',
        'CountryCodeChangingStatus',
    ];

    protected $hidden = [];

    public static function setAlteredInfo($jid, $username, $email, $bip)
    {
        if(config('global.options.register_confirmation')) {
            $EmailReceptionStatus = 'N';
            $EmailCertificationStatus = 'N';

        } else {
            $EmailReceptionStatus = 'Y';
            $EmailCertificationStatus = 'Y';
        }

        return self::create([
            'JID' => $jid,
            'AlterationDate' => now(),
            'LastName' => $username,
            'FirstName' => $username,
            'EmailAddr' => $email,
            'EmailReceptionStatus' => $EmailReceptionStatus,
            'EmailCertificationStatus' => $EmailCertificationStatus,
            'UserIP' => $bip,
            'CountryCode' => 'EG',
            'NickName' => $username,
            'ATypeCode' => 1,
            'CountryCodeChangingStatus' => 'N',
        ]);
    }
}
