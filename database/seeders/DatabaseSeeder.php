<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Donate\CoinbaseSeeder;
use Database\Seeders\Donate\DonationMethodsSeeder;
use Database\Seeders\Donate\MaxiCardSeeder;
use Database\Seeders\Donate\PayOpSeeder;
use Database\Seeders\Donate\PaypalSeeder;
use Database\Seeders\Donate\StripeSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //$this->call(MagOptSeeder::class);
        //$this->call(ItemNameSeeder::class);
    }
}
