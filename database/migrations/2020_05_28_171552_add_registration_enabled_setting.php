<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegistrationEnabledSetting extends Migration
{
    public function up(): void
    {
        DB::table('settings')->insert([
            'name' => 'registration_enabled',
            'value' => '0',
        ]);
    }

    public function down(): void
    {
        DB::table('settings')->where('name', '=', 'registration_enabled')->delete();
    }
}
