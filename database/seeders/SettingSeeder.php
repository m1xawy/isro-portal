<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->updateOrInsert(
            [
                'key' => 'site_title',
                'value' => 'Silkroad Online',
            ]
        );
        DB::table('settings')->updateOrInsert(
            [
                'key' => 'site_desc',
                'value' => "Silkroad Online is a World's first blockbuster Free to play MMORPG. Silkroad Olnine puts players deep into ancient Chinese, Islamic, and European civilization. Enjoy Silkroad's hardcore PvP, personal dungeon system, never ending fortress war and be the top of the highest heroes!",
            ]
        );
        DB::table('settings')->updateOrInsert(
            [
                'key' => 'site_url',
                'value' => 'https://localhost',
            ]
        );
        DB::table('settings')->updateOrInsert(
            [
                'key' => 'site_favicon',
                'value' => 'images/favicon.ico',
            ]
        );
        DB::table('settings')->updateOrInsert(
            [
                'key' => 'site_logo',
                'value' => 'images/logo.png',
            ]
        );
        DB::table('settings')->updateOrInsert(
            [
                'key' => 'dark_mode',
                'value' => 'dark',
            ]
        );
        DB::table('settings')->updateOrInsert(
            [
                'key' => 'disable_register',
                'value' => 0,
            ]
        );
    }
}
