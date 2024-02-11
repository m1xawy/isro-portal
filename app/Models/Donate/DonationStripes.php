<?php

namespace App\Models\Donate;

use Illuminate\Database\Eloquent\Model;

class DonationStripes extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'price', 'silk'
    ];
}
