<?php

namespace App\Models\SRO\Portal;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MuVIPInfo extends Model
{
    use HasFactory;

    protected $connection = 'portal';

    public $timestamps = false;

    protected $table = 'dbo.MU_VIP_Info';

    protected $primaryKey = 'JID';

    protected $fillable = [
        'JID',
        'VIPUserType',
        'VIPLv',
        'UpdateDate',
        'ExpireDate'
    ];
}
