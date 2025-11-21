<?php
namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        Warehouse::create([
            'name' => 'Gudang Pusat',
            'location' => 'Jakarta'
        ]);

        Warehouse::create([
            'name' => 'Gudang Cabang',
            'location' => 'Surabaya'
        ]);

        Warehouse::create([
            'name' => 'Gudang Timur',
            'location' => 'Makassar'
        ]);
    }
}