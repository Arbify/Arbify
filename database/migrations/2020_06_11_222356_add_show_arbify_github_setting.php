<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowArbifyGithubSetting extends Migration
{
    public function up(): void
    {
        DB::table('settings')->insert([
            'name' => 'show_arbify_github',
            'value' => '1',
        ]);
    }
    public function down(): void
    {
        DB::table('settings')->where('name', 'show_arbify_github')->delete();
    }
}
