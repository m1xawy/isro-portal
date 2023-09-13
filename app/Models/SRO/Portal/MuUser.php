<?php

namespace App\Models\SRO\Portal;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MuUser extends Model
{
    use HasFactory;

    protected $connection = 'portal';

    public $timestamps = false;

    protected $table = 'dbo.MU_User';

    protected $primaryKey = 'JID';

    protected $fillable = [
        'UserID',
        'UserPwd',
        'Gender',
        'Birthday',
        'NickName',
        'CountryCode',
        'AbusingCount',
    ];

    protected $hidden = [
        'password'
    ];

    public function getEmailUser()
    {
        return $this->hasOne(MuEmail::class, 'JID', 'JID');
    }

    public function getChangedSilk()
    {
        return $this->belongsTo(AphChangedSilk::class, 'JID', 'JID');
    }

    public function getWebUser()
    {
        return $this->hasOne(User::class, 'jid', 'JID');
    }
}
