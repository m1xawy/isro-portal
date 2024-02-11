<?php

namespace App\Models\Donate;

use Illuminate\Database\Eloquent\Model;

class DonationCoinbase extends Model
{

    protected $table = 'donation_coinbase';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'silk'
    ];
}
