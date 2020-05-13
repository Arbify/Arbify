<?php

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->insert([
            'name' => 'English (US)',
            'code' => 'en_US',
            'flag' => 'us',
        ]);

        DB::table('languages')->insert([
            'name' => 'English (UK)',
            'code' => 'en_UK',
            'flag' => 'gb-eng'
        ]);

        DB::table('languages')->insert([
            'name' => 'Polish',
            'code' => 'pl_PL',
            'flag' => 'pl',
        ]);
    }
}
