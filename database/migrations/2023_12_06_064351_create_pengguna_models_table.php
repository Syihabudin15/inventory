<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengguna_models', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string("first_name", 50);
            $table->string("last_name", 50);
            $table->string("username", 50)->unique();
            $table->string("password", 255)->hash();
            $table->enum("role", ['ADMIN', "MANAJER"]);
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengguna_models');
    }
};
