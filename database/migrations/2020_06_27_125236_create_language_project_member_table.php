<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguageProjectMemberTable extends Migration
{
    public function up(): void
    {
        Schema::create('language_project_member', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('language_project_member');
    }
}
