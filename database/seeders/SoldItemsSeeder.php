<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Products;
use App\Models\SoldItems;
use Illuminate\Database\Seeder;

class SoldItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SoldItems::factory()
        // ->for([Products::factory()->count(5), Cart::factory()->count(7)])
            ->for(Products::factory()->count(5))
            ->for(Cart::factory()->count(7))
            ->create();
    }
}
