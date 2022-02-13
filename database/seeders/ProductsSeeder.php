<?php

namespace Database\Seeders;

use App\Models\Images;
use App\Models\Products;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Products::factory()
            ->count(20)
            ->has(Images::factory()->count(rand(1,5)))
            ->create();
    }
}
