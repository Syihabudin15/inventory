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
        Schema::create('supplier_models', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('company_name', 255)->unique();
            $table->string('address', 255);
            $table->string('sub_district', 100)->nullable(true);
            $table->string('city', 100);
            $table->integer('zip_code', false)->length(5);
            $table->string('country', 100);
            $table->string('email', 100)->nullable(true);
            $table->string('no_telepon', 13)->unique();
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_models');
    }
};
