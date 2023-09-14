<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\SRO\Portal\MuUser;
use App\Models\SRO\Portal\MuVIPInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'jid',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getJCash()
    {
        $JCash = DB::select("
            Declare @PremiumSilk Int
            ,@Silk Int
            ,@VipLevel Int
            ,@UsageMonth Int
            ,@Usage3Month Int;

            EXEC [GB_JoymaxPortal].[dbo].[B_GetJCash] ".$this->jid."
            ,@PremiumSilk Output
            ,@Silk Output
            ,@VipLevel Output
            ,@UsageMonth Output
            ,@Usage3Month Output;

            Select @PremiumSilk as 'PremiumSilk'
            ,@Silk as 'Silk'
            ,@VipLevel as 'VIP'
            ,@UsageMonth as 'UsageMonth'
            ,@Usage3Month as 'Usage3Month'
            "
        );

        if($JCash) {
            return $JCash[0];
        }

        return null;
    }

    public function getVIPInfo()
    {
        //$vip_config = config('vip-info');
        $vip_info = DB::select("Select * From [GB_JoymaxPortal].[dbo].[MU_VIP_Info] with(nolock) Where JID = ".$this->jid." AND ExpireDate >= GETDATE()");

        if($vip_info) {
            return $vip_info[0];
        }

        return null;
    }

    public function getMuUser()
    {
        return $this->belongsTo(MuUser::class, 'jid', 'JID');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
