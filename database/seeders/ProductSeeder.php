<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat 100 produk acak menggunakan ProductFactory
        Product::factory()->count(100)->create();
        
        $this->command->info('✅ 100 Produk telah berhasil ditambahkan.');
    }
}
