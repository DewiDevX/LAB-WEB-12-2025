<?php
namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $elektronik = Category::where('name', 'Elektronik')->first();
            $pakaian = Category::where('name', 'Pakaian')->first();
            $makanan = Category::where('name', 'Makanan')->first();

            $gudangPusat = Warehouse::where('name', 'Gudang Pusat')->first();
            $gudangCabang = Warehouse::where('name', 'Gudang Cabang')->first();

            // Produk 1: Laptop
            $laptop = Product::create([
                'name' => 'Laptop ASUS ROG',
                'price' => 15000000,
                'category_id' => $elektronik->id
            ]);

            $laptop->detail()->create([
                'description' => 'Laptop gaming dengan processor Intel i7 dan GPU RTX 3060',
                'weight' => 2.5,
                'size' => '15.6 inch'
            ]);

            $laptop->warehouses()->attach($gudangPusat->id, ['quantity' => 10]);
            $laptop->warehouses()->attach($gudangCabang->id, ['quantity' => 5]);

            // Produk 2: Smartphone
            $smartphone = Product::create([
                'name' => 'Samsung Galaxy S21',
                'price' => 8000000,
                'category_id' => $elektronik->id
            ]);

            $smartphone->detail()->create([
                'description' => 'Smartphone flagship dengan kamera 108MP',
                'weight' => 0.2,
                'size' => '6.2 inch'
            ]);

            $smartphone->warehouses()->attach($gudangPusat->id, ['quantity' => 25]);

            // Produk 3: Kaos
            $kaos = Product::create([
                'name' => 'Kaos Polos Cotton',
                'price' => 75000,
                'category_id' => $pakaian->id
            ]);

            $kaos->detail()->create([
                'description' => 'Kaos bahan cotton combed 30s premium',
                'weight' => 0.3,
                'size' => 'L'
            ]);

            $kaos->warehouses()->attach($gudangPusat->id, ['quantity' => 100]);
            $kaos->warehouses()->attach($gudangCabang->id, ['quantity' => 50]);

            // Produk 4: Snack
            $snack = Product::create([
                'name' => 'Keripik Kentang',
                'price' => 15000,
                'category_id' => $makanan->id
            ]);

            $snack->detail()->create([
                'description' => 'Keripik kentang rasa balado',
                'weight' => 0.15,
                'size' => '150g'
            ]);

            $snack->warehouses()->attach($gudangPusat->id, ['quantity' => 200]);
        });
    }
}