<?php

namespace Database\Seeders;

use App\Models\Variant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 2; $i++) { 
            Variant::create([
                'produk_id' => 1,
                'warna' => 'Merah',
                'ukuran' => $i + 1,
                'harga' => 1000,
                'stok' => 10,
            ]);
        }
    }
}
