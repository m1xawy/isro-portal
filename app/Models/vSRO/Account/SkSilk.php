<?php

namespace App\Models\vSRO\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkSilk extends Model
{
    use HasFactory;

    protected $connection = 'vsro_account';

    public $timestamps = false;

    protected $table = 'dbo.SK_Silk';

    protected $primaryKey = 'JID';

    protected $fillable = [
        'JID',
        'silk_own',
        'silk_gift',
        'silk_point'
    ];
}
