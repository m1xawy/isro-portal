<?php

namespace App\Helpers\Donate\PayOp;

use App\Models\Donate\DonationMethods;
use App\Models\Donate\DonationPayOp;
use App\Models\Donate\PayOpInvoices;
use App\Models\User;
use Exception;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class PayOpHelper
{

    /**
     * @var Repository|Application|mixed
     */
    private $key, $secret, $token;

    public function __construct()
    {
        $this->key = config('payop.key');
        $this->secret = config('payop.secret');
        $this->token = config('payop.token');
    }

    /**
     * @param PayOpInvoices $order
     * @param User $user
     * @param DonationPayOp $package
     * @return object
     * @throws Exception
     */
    public function createInvoice(PayOpInvoices $order, User $user, DonationPayOp $package): object
    {
        // Get donation method
        $method = DonationMethods::query()
            ->where('name', 'payop')
            ->where('active', true)
            ->firstOrFail();

        // Set signature data
        $signatureData = collect([
            'id' => $order->id,
            'amount' => $order->price,
            'currency' => $method->currency,
        ])
            ->sortKeys(SORT_STRING);
        $signatureData = $signatureData->push($this->secret)
            ->implode(':');

        // Hash signature
        $signature = hash('sha256', $signatureData);

        // Get app name
        $app_name = config('app.name', 'Devsome');

        // Get rules url
        $rules_url = config('app.rules_url');

        // Set description
        $description = "{$package->name} Package - {$app_name} - Game Username: {$user->silkroad_id} User agreed to the rules stated on: {$rules_url}";

        $invoice = Http::asJson()
            ->post('https://payop.com/v1/invoices/create', [
                'publicKey' => $this->key,
                'order' => [
                    'id' => $order->id,
                    'amount' => $order->price,
                    'currency' => $method->currency,
                    'items' => [
                        'id' => $package->id,
                        'name' => $package->name,
                        'price' => $package->price
                    ],
                    "description" => $description
                ],
                'signature' => $signature,
                'language' => 'en',
                'payer' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'metadata' => [
                    'payload' => $order->payload,
                ],
                'resultUrl' => route('donate-payop-success', ['orderId' => $order->id]),
                'failPath' => route('donate-payop-error', ['orderId' => $order->id])
            ]);
        if ($invoice->successful()) {
            return $invoice->object();
        }
        throw new Exception($invoice->body());
    }

    /**
     * @param string $invoiceId
     * @return object
     * @throws Exception
     */
    public function getInvoice(string $invoiceId): object
    {
        // Send get invoice request
        $invoice = Http::withToken($this->token)
            ->asJson()
            ->get("https://payop.com/v1/invoices/{$invoiceId}");

        // Return invoice as object if successful
        if ($invoice->successful()) {
            return $invoice->object();
        }

        // Throw an exception if failed
        throw new Exception($invoice->body());
    }


    /**
     * @param string $transactionId
     * @return object
     * @throws Exception
     */
    public function getTransaction(string $transactionId): object
    {
        // Send get invoice request
        $invoice = Http::withToken($this->token)
            ->asJson()
            ->get("https://payop.com/v1/transactions/{$transactionId}");

        // Return invoice as object if successful
        if ($invoice->successful()) {
            return $invoice->object();
        }

        // Throw an exception if failed
        throw new Exception($invoice->body());
    }

    /**
     * @param int $status
     * @return string
     */
    public function getTransactionStatus(int $status): string
    {
        switch ($status) {
            case 1:
            case 4:
                return 'pending';
                break;
            case 2:
                return 'paid';
                break;
            case 5:
            case 3:
            default:
                return 'declined';
                break;
        }
    }

    /**
     * @param int $status
     * @return string
     */
    public function getInvoiceStatus(int $status): string
    {
        switch ($status) {
            case 0:
            case 4:
                return 'pending';
                break;
            case 1:
                return 'paid';
                break;
            case 5:
            case 3:
            default:
                return 'declined';
                break;
        }
    }

    /**
     * @param PayOpInvoices $order
     * @param Collection $transaction
     * @return bool
     */
    public function validateHash(PayOpInvoices $order, Collection $transaction): bool
    {
        // Get donation method
        $method = DonationMethods::query()
            ->where('name', 'payop')
            ->where('active', true)
            ->firstOrFail();

        // Set signature data
        $orderData = collect([
            'id' => $order->id,
            'price' => $order->price,
            'currency' => $method->currency,
        ])
            ->sortKeys(SORT_STRING);

        $orderData = $orderData->push($this->secret)
            ->implode(':');

        // Hash signature
        $orderHash = hash('sha256', $orderData);

        // Set signature data
        $transactionData = collect([
            'id' => $transaction->get('orderId'),
            'price' => $transaction->get('amount'),
            'currency' => $transaction->get('currency'),
        ])
            ->sortKeys(SORT_STRING);

        $transactionData = $transactionData->push($this->secret)
            ->implode(':');

        // Hash signature
        $transactionHash = hash('sha256', $transactionData);

        return $orderHash === $transactionHash;
    }
}
