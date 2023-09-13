<?php

namespace App\Models\SRO\Portal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuhAgreedService extends Model
{
    use HasFactory;

    protected $connection = 'portal';

    public $timestamps = false;

    protected $table = 'dbo.AUH_AgreedService';

    protected $primaryKey = 'JID';

    protected $fillable = [
        'JID',
        'ServiceCode',
        'StartDate',
        'EndDate',
        'UserIP'
    ];
}
