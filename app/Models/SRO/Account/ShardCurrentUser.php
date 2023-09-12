<?php

namespace App\Models\SRO\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShardCurrentUser extends Model
{
    use HasFactory;

    protected $connection = 'account';

    public $timestamps = false;

    protected $table = 'dbo._ShardCurrentUser';

    protected $fillable = [];
}
