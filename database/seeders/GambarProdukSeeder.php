<?php

namespace Database\Seeders;

use App\Models\GambarProduk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GambarProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 2; $i++) { 
            GambarProduk::create([
                'produk_id' => 1,
                'url' => 'https://via.placeholder.com/150',
            ]);
        }
    }
}
