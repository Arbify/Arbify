<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOnDeletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('message_values', function (Blueprint $table) {
           $table->dropForeign('message_values_message_id_foreign');
           $table->foreign('message_id')
               ->references('id')
               ->on('messages')
               ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('message_values', function (Blueprint $table) {
            $table->dropForeign('message_id');
            $table->foreign('message_values_message_id_foreign')
                ->references('id')
                ->on('messages');
        });
    }
}
