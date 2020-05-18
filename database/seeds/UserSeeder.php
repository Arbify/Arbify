<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@arbify.io',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}
