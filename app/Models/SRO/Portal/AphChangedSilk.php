<?php

namespace App\Models\SRO\Portal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AphChangedSilk extends Model
{
    use HasFactory;

    protected $connection = 'portal';

    protected $table = 'dbo.APH_ChangedSilk';

    protected $primaryKey = 'CSID';

    protected $fillable = [
        'InvoiceID',
        'PTInvoiceID',
        'JID',
        'RemainedSilk',
        'ChangedSilk',
        'SilkType',
        'SellingTypeID',
        'ChangeDate',
        'AvailableDate',
        'AvailableStatus',
    ];

    public static function setChangedSilk($jid, $type, $amount)
    {
        return self::create([
            'JID' => $jid,
            'RemainedSilk' => 0,
            'ChangedSilk' => $amount,
            'SilkType' => $type,
            'SellingTypeID' => 2,
            'ChangeDate' => now(),
            'AvailableDate' => now()->addYears(1),
            'AvailableStatus' => 'Y',
        ]);
    }

    public static function getDonateHistory($jid)
    {
        return Cache::remember('donate_history', now()->addMinutes(config('global.general.cache.data.account')), function () use ($jid) {
            return self::where('JID', $jid)->orderBy('ChangeDate', 'DESC')->get();
        });
    }
}
