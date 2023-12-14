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
        Schema::create('barang_models', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string("product_code", 20)->unique();
            $table->string("name", 100)->unique();
            $table->bigInteger("price", false)->length(100);
            $table->bigInteger("min_stock", false)->length(100);
            $table->bigInteger("stock", false)->length(100);
            $table->boolean('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_models');
    }
};
