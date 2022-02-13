<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Images;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categories::factory()
            ->count(10)
            ->has(Images::factory()->count(1))
            ->create();
    }
}
