<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMessageValueValueToText extends Migration
{
    public function up(): void
    {
        Schema::table('message_values', function (Blueprint $table) {
            $table->text('value')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('message_values', function (Blueprint $table) {
            $table->string('value')->nullable()->change();
        });
    }
}
