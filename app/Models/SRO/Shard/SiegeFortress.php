<?php

namespace App\Models\SRO\Shard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiegeFortress extends Model
{
    use HasFactory;

    protected $connection = 'shard';

    public $timestamps = false;

    protected $table = 'dbo._SiegeFortress';

    protected $primaryKey = 'FortressID';

    protected $fillable = [];

    protected $dates = [
        'CreatedDungeonTime'
    ];

    protected $dateFormat = 'Y-m-d H:i:s';

    public function getGuildName()
    {
        $query = $this->hasOne(Guild::class, 'ID', 'GuildID');
        $query->where('ID', '!=', 0);
        return $query;
    }
}
