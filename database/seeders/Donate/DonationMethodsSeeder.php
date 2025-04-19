<?php

namespace Database\Seeders\Donate;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DonationMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('donation_methods')->updateOrInsert(
            [
                'method' => 'paypal'
            ],
            [
                'name' => 'PayPal',
                'image' => 'paypal.png',
                'currency' => 'USD',
                'active' => 0,
                'created_at' => \Carbon\Carbon::now(),
            ]);

        DB::table('donation_methods')->updateOrInsert(
            [
                'method' => 'stripe'
            ],
            [
                'name' => 'Stripe',
                'image' => 'stripe.png',
                'currency' => 'EUR',
                'active' => 0,
                'created_at' => \Carbon\Carbon::now(),
            ]);

        DB::table('donation_methods')->updateOrInsert(
            [
                'method' => 'maxicard'
            ],
            [
                'name' => 'MaxiCard',
                'image' => 'maxicard.png',
                'currency' => 'TL',
                'active' => 0,
                'created_at' => \Carbon\Carbon::now(),
            ]);

        DB::table('donation_methods')->updateOrInsert(
            [
                'method' => 'payop'
            ],
            [
                'name' => 'PayOp',
                'image' => 'payop.svg',
                'currency' => 'USD',
                'active' => 0,
                'created_at' => \Carbon\Carbon::now(),
            ]);

        DB::table('donation_methods')->updateOrInsert(
            [
                'method' => 'coinbase'
            ],
            [
                'name' => 'Coinbase',
                'image' => 'coinbase.png',
                'currency' => 'USD',
                'active' => 0,
                'created_at' => \Carbon\Carbon::now(),
            ]);
    }
}
