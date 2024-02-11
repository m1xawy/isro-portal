<?php

namespace App\Models\Donate;

use Illuminate\Database\Eloquent\Model;

class DonationPayOp extends Model
{

    protected $table = 'donation_payop';

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
