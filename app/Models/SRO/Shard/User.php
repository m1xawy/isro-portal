<?php

namespace App\Models\SRO\Shard;

use App\Models\SRO\Account\TbUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $connection = 'shard';

    public $timestamps = false;

    protected $table = 'dbo._User';
    protected $fillable = [
        'UserJID', 'CharID'
    ];

    public function getTbUser()
    {
        return $this->belongsTo(TbUser::class, 'UserJID', 'JID');
    }
}
