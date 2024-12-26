<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Product::create([
            'name' => 'Product 1',
            'rate' => 100,
            'unit'=>10
        ]);

        Product::create([
            'name' => 'Product 2',
            'rate' => 200,
            'unit'=>5
        ]);

        Product::create([
            'name' => 'Product 3',
            'rate' => 600,
            'unit'=>10
        ]);

        Product::create([
            'name' => 'Product 4',
            'rate' => 400,
            'unit'=>11
        ]);
    }
}