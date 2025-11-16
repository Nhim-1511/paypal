<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \App\Models\Product::insert([
        ['name' => 'Áo thun nam', 'price' => 5, 'image' => 'ao1.jpg', 'description' => 'Áo thun cotton mềm mại'],
        ['name' => 'Quần jeans nữ', 'price' => 10, 'image' => 'quan1.jpg', 'description' => 'Quần jeans co giãn thoải mái'],
        ]);
    }
}
