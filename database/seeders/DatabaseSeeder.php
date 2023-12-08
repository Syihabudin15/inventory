<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\BarangModel;
use App\Models\PenggunaModel;
use App\Models\SupplierModel;
use App\Models\TransaksiBarangModel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        PenggunaModel::factory(2)->create();
        SupplierModel::factory(5)->create();
        BarangModel::factory(20)->create();
        TransaksiBarangModel::factory(10)->create();
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
