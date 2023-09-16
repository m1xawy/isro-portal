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
        $JCash = cache()->remember('j_cash', $seconds = 10, function() {
            return collect(DB::select("
            Declare @ReturnValue Int
            Declare @PremiumSilk Int
            Declare @Silk Int;
            Declare @VipLevel Int
            Declare @UsageMonth Int
            Declare @Usage3Month Int;
            SET NOCOUNT ON;

            Execute @ReturnValue = [GB_JoymaxPortal].[dbo].[B_GetJCash]
                ".$this->jid.",
                @PremiumSilk Output,
                @Silk Output,
                @VipLevel Output,
                @UsageMonth Output,
                @Usage3Month Output;

            Select
                @ReturnValue AS 'ErrorCode',
                @PremiumSilk AS 'PremiumSilk',
                @Silk AS 'Silk'
            "
            ))->first();
        });

        if($JCash->ErrorCode != 0) {
            return null;
        }

        return $JCash;
    }

    public function getVIPInfo()
    {
        $VIPInfo = cache()->remember('vip_info', $seconds = 10, function() {
            return collect(DB::select("Select * From [GB_JoymaxPortal].[dbo].[MU_VIP_Info] with(nolock) Where JID = ".$this->jid." AND ExpireDate >= GETDATE()"))->first();
        });

        if(!$VIPInfo) {
            return null;
        }

        return $VIPInfo;
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
