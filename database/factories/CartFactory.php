<?php

namespace Database\Factories;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cart::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firstname' => $this->faker->name(),
            'lastname' => $this->faker->name(),
            'email' => $this->faker->email(),
            'mobile' => $this->faker->randomNumber(),
            'mobile2' => $this->faker->randomNumber(),
            'governorate' => $this->faker->word(),
            'address' => $this->faker->word(),
            'comment' => $this->faker->text()
        ];
    }
}
