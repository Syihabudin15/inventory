<?php

namespace Database\Seeders;

use App\Models\PenggunaModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PenggunaModel::factory(1)->create();
        PenggunaModel::create([
            "first_name" => "Syihabudin",
            "last_name" => "Tsani",
            "username" => "syihabudin15",
            "password" => Hash::make("Tsani182"),
            "role" => "ADMIN",
            "is_active" => true
        ]);

    }
}
