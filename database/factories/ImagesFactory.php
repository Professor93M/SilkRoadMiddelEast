<?php

namespace Database\Factories;

use App\Models\Categories;
use App\Models\Images;
use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImagesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Images::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $imageable = [
            Products::class,
            Categories::class
        ];
        return [
            'img_url' => $this->faker->imageUrl(200,200),
            'img_id' => $this->faker->numberBetween(1,10),
            'img_type' => $this->faker->randomElement($imageable),
        ];
    }
}