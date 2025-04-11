<?php

namespace Database\Seeders\Donate;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaxiCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('maxi_card_epin')->updateOrInsert(
            ['name' => "Maxicard 1TL"],
            [
                'description' => "Maxicard 1TL",
                'price' => 1,
                'silk' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        DB::table('maxi_card_epin')->updateOrInsert(
            ['name' => "Maxicard 5TL"],
            [
                'description' => "Maxicard 5TL",
                'price' => 5,
                'silk' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        DB::table('maxi_card_epin')->updateOrInsert(
            ['name' => "Maxicard 10TL"],
            [
                'description' => "Maxicard 10TL",
                'price' => 10,
                'silk' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        DB::table('maxi_card_epin')->updateOrInsert(
            ['name' => "Maxicard 25TL"],
            [
                'description' => "Maxicard 25TL",
                'price' => 25,
                'silk' => 25,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        DB::table('maxi_card_epin')->updateOrInsert(
            ['name' => "Maxicard 50TL"],
            [
                'description' => "Maxicard 50TL",
                'price' => 50,
                'silk' => 50,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        DB::table('maxi_card_epin')->updateOrInsert(
            ['name' => "Maxicard 75TL"],
            [
                'description' => "Maxicard 75TL",
                'price' => 75,
                'silk' => 75,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        DB::table('maxi_card_epin')->updateOrInsert(
            ['name' => "Maxicard 100TL"],
            [
                'description' => "Maxicard 100TL",
                'price' => 100,
                'silk' => 100,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        DB::table('maxi_card_epin')->updateOrInsert(
            ['name' => "Maxicard 250TL"],
            [
                'description' => "Maxicard 250TL",
                'price' => 250,
                'silk' => 250,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        DB::table('maxi_card_epin')->updateOrInsert(
            ['name' => "Maxicard 500TL"],
            [
                'description' => "Maxicard 500TL",
                'price' => 500,
                'silk' => 500,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        DB::table('maxi_card_epin')->updateOrInsert(
            ['name' => "Maxicard 1000TL"],
            [
                'description' => "Maxicard 1000TL",
                'price' => 1000,
                'silk' => 1000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
    }
}
