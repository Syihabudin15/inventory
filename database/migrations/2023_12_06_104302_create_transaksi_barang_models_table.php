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
        Schema::create('transaksi_barang_models', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId('pengguna_id')->constrained("pengguna_models");
            $table->foreignId('barang_id')->constrained("barang_models");
            $table->foreignId('supplier_id')->constrained("supplier_models");
            $table->integer('quantity', false)->length(100);
            $table->enum('status', ["MASUK", "KELUAR", "RUSAK"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_barang_models');
    }
};
 