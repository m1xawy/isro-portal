<?php

namespace App\Models\SRO\Shard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Char extends Model
{
    use HasFactory;

    protected $connection = 'shard';
    public $timestamps = false;

    protected $table = 'dbo._Char';
    protected $primaryKey = 'CharID';
    protected $fillable = [
        'CharID',
        'Deleted',
        'RefObjID',
        'CharName16',
        'NickName16',
        'LastLogout',
        'RemainGold'
    ];
    protected $dates = [
        'LastLogout'
    ];
    protected $dateFormat = 'Y-m-d H:i:s';

    public function getAccountUser()
    {
        return $this->belongsTo(User::class, 'CharID', 'CharID');
    }
}
