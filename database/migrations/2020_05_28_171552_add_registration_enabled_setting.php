<?php

use Illuminate\Database\Migrations\Migration;

class AddRegistrationEnabledSetting extends Migration
{
    public function up(): void
    {
        DB::table('settings')->insert([
            'name' => 'registration_enabled',
            'value' => '1',
        ]);
    }

    public function down(): void
    {
        DB::table('settings')->where('name', '=', 'registration_enabled')->delete();
    }
}
