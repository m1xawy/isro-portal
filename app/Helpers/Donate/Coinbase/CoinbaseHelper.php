<?php

namespace App\Helpers\Donate\Coinbase;

use Exception;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Http;

class CoinbaseHelper
{

    /**
     * @var Repository|Application|mixed
     */
    private $api_key, $version;

    public function __construct()
    {
        $this->api_key = config('coinbase.key');
        $this->version = config('coinbase.version');
    }

    /**
     * @param array $data
     * @param $user
     * @return object
     * @throws Exception
     */
    public function createInvoice(array $data, $user): object
    {
        $first_name = explode(' ', $user->name)[0];
        $last_name = explode(' ', $user->name)[1] ?? $first_name;
        $invoice = Http::withHeaders([
            'X-CC-Api-Key' => $this->api_key,
            'X-CC-Version' => $this->version,
        ])
            ->asJson()
            ->post('https://api.commerce.coinbase.com/invoices', [
                'business_name' => config('app.name'),
                'customer_email' => $user->email,
                'customer_name' => $user->name,
                'local_price' => [
                    'amount' => $data['amount'],
                    'currency' => 'USD',
                ],
                'memo' => $data['description'],
                /*'name' => $data['name'],
                'description' => $data['description'],
                'pricing_type'=> 'no_price',
                'metadata' => [
                    'customer_id' => $user->id,
                    'customer_name' => $user->name,
                ],
                'redirect_url' => config('app.url'),*/
                'custom' => 'QstwNczDpI2mCHmDhPZXQJLNRQcpuJ0ti5ZsQhL6HWL9OVjn',
            ]);
        if ($invoice->successful()) {
            return $invoice->object()->data;
        }
        throw new Exception($invoice->body());
    }
}
