<?php

namespace App\Models\Donate;

use Illuminate\Database\Eloquent\Model;

class DonationMethods extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'model', 'active'
    ];
}
