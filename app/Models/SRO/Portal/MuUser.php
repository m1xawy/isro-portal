<?php

namespace App\Models\SRO\Portal;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MuUser extends Model
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
    protected $table = 'dbo.MU_User';

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

    public static function setPortalAccount($username, $password)
    {
        return self::create([
            'UserID' => $username,
            'UserPwd' => md5($password),
            'Gender' => 'M',
            'Birthday' => now(),
            'NickName' => $username,
            'CountryCode' => 'EG',
            'AbusingCount' => 0,
        ]);
    }

    public function getEmailUser(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(MuEmail::class, 'JID', 'JID');
    }

    public function getVipLevel(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MuVIPInfo::class, 'JID', 'JID');
    }

    public function getChangedSilk(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AphChangedSilk::class, 'JID', 'JID');
    }

    public function getWebUser(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class, 'jid', 'JID');
    }
}
