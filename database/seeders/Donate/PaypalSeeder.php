<?php

namespace Database\Seeders\Donate;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaypalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('donation_paypals')->updateOrInsert(
            [
                'name' => "100 Silk",
                'description' => "Pay 1 USD for 100 Silk",
                'price' => 1,
                'silk' => 100,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        DB::table('donation_paypals')->updateOrInsert(
            [
                'name' => "500 Silk",
                'description' => "Pay 5 USD for 500 Silk",
                'price' => 5,
                'silk' => 500,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        DB::table('donation_paypals')->updateOrInsert(
            [
                'name' => "1000 Silk",
                'description' => "Pay 10 USD for 1000 Silk",
                'price' => 10,
                'silk' => 1000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        DB::table('donation_paypals')->updateOrInsert(
            [
                'name' => "2500 Silk",
                'description' => "Pay 25 USD for 2500 Silk",
                'price' => 25,
                'silk' => 2500,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        DB::table('donation_paypals')->updateOrInsert(
            [
                'name' => "5000 Silk",
                'description' => "Pay 50 USD for 5000 Silk",
                'price' => 50,
                'silk' => 5000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        DB::table('donation_paypals')->updateOrInsert(
            [
                'name' => "7500 Silk",
                'description' => "Pay 75 USD for 7500 Silk",
                'price' => 75,
                'silk' => 7500,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        DB::table('donation_paypals')->updateOrInsert(
            [
                'name' => "10000 Silk",
                'description' => "Pay 100 USD for 10000 Silk",
                'price' => 100,
                'silk' => 10000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        DB::table('donation_paypals')->updateOrInsert(
            [
                'name' => "250000 Silk",
                'description' => "Pay 250 USD for 25000 Silk",
                'price' => 250,
                'silk' => 25000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        DB::table('donation_paypals')->updateOrInsert(
            [
                'name' => "500000 Silk",
                'description' => "Pay 500 USD for 50000 Silk",
                'price' => 500,
                'silk' => 50000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        DB::table('donation_paypals')->updateOrInsert(
            [
                'name' => "100000 Silk",
                'description' => "Pay 1000 USD for 100000 Silk",
                'price' => 1000,
                'silk' => 100000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
    }
}
