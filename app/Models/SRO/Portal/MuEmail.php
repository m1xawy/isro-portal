<?php

namespace App\Models\SRO\Portal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MuEmail extends Model
{
    use HasFactory;

    protected $connection = 'portal';

    public $timestamps = false;

    protected $table = 'dbo.MU_Email';
    protected $primaryKey = 'JID';

    protected $fillable = [
        'JID',
        'EmailAddr',
    ];
}
