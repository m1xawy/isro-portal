<?php

namespace App\Models\SRO\Shard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharUniqueKill extends Model
{
    use HasFactory;

    protected $connection = 'shard';

    public $timestamps = false;

    protected $table = 'dbo._CharUniqueKill';

    protected $fillable = [
        'CharID',
        'MobID'
    ];

    protected $casts = [
        'Points' => 'integer'
    ];

    public function getCharacter()
    {
        return $this->belongsTo(Char::class, 'CharID', 'CharID');
    }
}
