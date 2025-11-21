<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Elektronik', 'description' => 'Produk elektronik']);
        Category::create(['name' => 'Pakaian', 'description' => 'Fashion dan pakaian']);
        Category::create(['name' => 'Makanan', 'description' => 'Makanan dan minuman']);
    }
}