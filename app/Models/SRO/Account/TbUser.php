<?php

namespace App\Models\SRO\Account;

use App\Models\SRO\Portal\MuUser;
use App\Models\SRO\Shard\Char;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbUser extends Model
{
    use HasFactory;

    protected $connection = 'account';
    public $timestamps = false;

    protected $table = 'dbo.TB_User';
    protected $primaryKey = 'JID';

    protected $fillable = [
        'PortalJID',
        'StrUserID',
        'ServiceCompany',
        'password',
        'Active',
        'UserIP',
        'CountryCode',
        'VisitDate',
        'RegDate',
        'sec_primary',
        'sec_content',
        'sec_grade',
    ];

    protected $hidden = [
        'password'
    ];

    public static function setGameAccount($jid, $username, $password, $ip)
    {
        return self::create([
            'PortalJID' => $jid,
            'StrUserID' => $username,
            'ServiceCompany' => 11,
            'password' => md5($password),
            'Active' => 1,
            'UserIP' => $ip,
            'CountryCode' => 'EG',
            'VisitDate' => now(),
            'RegDate' => now(),
            'sec_primary' => 3,
            'sec_content' => 3,
            'sec_grade' => 0,
        ]);
    }

    public function getShardUser()
    {
        return $this->belongsToMany(Char::class, '_User', 'UserJID', 'CharID');
    }

    public function getPortalUser()
    {
        return $this->hasOne(MuUser::class, 'JID', 'PortalJID');
    }
}
