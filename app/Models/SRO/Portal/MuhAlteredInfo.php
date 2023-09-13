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
}
