<?php

namespace App\Models\SRO\Portal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MuhAlteredInfo extends Model
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
    protected $table = 'dbo.MUH_AlteredInfo';

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
        if(config('settings.options.register_confirmation')) {
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
