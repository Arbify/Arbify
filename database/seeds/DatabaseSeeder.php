<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
         $this->call(LanguageSeeder::class);
         $this->call(UserSeeder::class);
    }
}
