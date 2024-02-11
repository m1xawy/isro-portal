<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        $this->call(DonationMethodsSeeder::class);
        $this->call(MaxiCardSeeder::class);
        $this->call(PaypalSeeder::class);
        $this->call(StripeSeeder::class);
        $this->call(PayOpSeeder::class);
        $this->call(CoinbaseSeeder::class);
    }
}
