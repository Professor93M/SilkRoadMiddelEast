<?php

namespace Database\Factories;

use App\Models\SoldItems;
use Illuminate\Database\Eloquent\Factories\Factory;

class SoldItemsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SoldItems::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'products_id' => $this->faker->randomNumber(),
            'cart_id' => $this->faker->randomNumber()
        ];
    }
}
