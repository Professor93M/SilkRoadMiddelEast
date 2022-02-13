<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\SoldItems;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cart::factory()->count(20)->create();
    }
}
