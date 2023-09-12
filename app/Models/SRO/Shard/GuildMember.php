<?php

namespace App\Models\SRO\Shard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuildMember extends Model
{
    use HasFactory;

    protected $connection = 'shard';

    public $timestamps = false;

    protected $table = 'dbo._GuildMember';

    protected $primaryKey = 'GuildID';

    protected $fillable = [];

    protected $dates = [
        'JoinDate'
    ];

    protected $dateFormat = 'Y-m-d H:i:s';
}
