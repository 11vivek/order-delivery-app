<?php

namespace Database\Seeders;

use App\Models\DeliveryBoy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryBoysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DeliveryBoy::insert([
            ['name' => 'A', 'capacity' => 2, 'delivery_duration' => 30],
            ['name' => 'B', 'capacity' => 4, 'delivery_duration' => 30],
            ['name' => 'C', 'capacity' => 5, 'delivery_duration' => 30],
            ['name' => 'D', 'capacity' => 3, 'delivery_duration' => 30],
        ]);
    }
}
