<?php

namespace App\Models\SRO\Shard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guild extends Model
{
    use HasFactory;

    protected $connection = 'shard';

    public $timestamps = false;

    protected $table = 'dbo._Guild';

    protected $primaryKey = 'ID';

    protected $fillable = [];

    protected $dates = [
        'FoundationDate'
    ];

    protected $dateFormat = 'Y-m-d H:i:s';

    public function getGuildMembers()
    {
        return $this->hasMany(GuildMember::class, 'GuildID', 'ID');
    }
}
