<?php

namespace Database\Factories;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Products::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pd_name' => $this->faker->name(),
            'pd_category' => $this->faker->word(), 
            'pd_price' => $this->faker->randomNumber(5), 
            'pd_stack' => $this->faker->randomNumber(2), 
            'pd_state' => $this->faker->boolean(),
            'pd_description' => $this->faker->text(), 
            'cat_id' => Categories::all()->random()->cat_id
        ];
    }
}
