<?php

namespace App\Models\vSRO\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbUser extends Model
{
    use HasFactory;

    protected $connection = 'vsro_account';

    public $timestamps = false;

    protected $table = 'dbo.TB_User';

    protected $primaryKey = 'JID';

    protected $fillable = [
        'StrUserID',
        'password',
        'Email',
        'regtime',
        'reg_ip',
        'sec_primary',
        'sec_content',
        'AccPlayTime',
        'LatestUpdateTime_ToPlayTime',
        'Play123Time'
    ];

    protected $hidden = [
        'password'
    ];

    public function getSkSilk()
    {
        return $this->belongsTo(SkSilk::class, 'JID', 'JID');
    }

    public function getWebUser()
    {
        return $this->hasOne(User::class, 'jid', 'JID');
    }
}
