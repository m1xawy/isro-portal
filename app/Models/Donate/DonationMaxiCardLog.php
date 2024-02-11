<?php

namespace App\Models\Donate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DonationMaxiCardLog extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'maxi_card_epin_log';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'order_number',
        'epin_code',
        'epin_password',
        'epin_amount_id',
        'epin_amount',
        'commission',
    ];

    /**
     * @return BelongsTo
     */
    public function epin(): BelongsTo
    {
        return $this->belongsTo(DonationMaxiCard::class, 'epin_amount_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
