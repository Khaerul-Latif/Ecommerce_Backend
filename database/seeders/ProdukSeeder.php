<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 2; $i++) { 
            Produk::create([
                'nama' => 'Produk ' . $i,
                'deskripsi' => 'Deskripsi Produk ' . $i,
                'slug' => 'produk-' . $i,
                'kategori_id' => 1,
                'display' => true,
                'dimension' => '10x10x10',
                'berat' => 100,
                'material' => 'kayu',
            ]);
        }
    }
}
