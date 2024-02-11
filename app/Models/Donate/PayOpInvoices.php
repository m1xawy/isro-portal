<?php

namespace App\Models\Donate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayOpInvoices extends Model
{
    /**
     * @var string
     */
    protected $table = 'payop_invoices';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'invoice_id',
        'data',
        'payload',
        'name',
        'price',
        'silk',
        'state'
    ];

    protected $casts = [
        'data' => 'json',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
