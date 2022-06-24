<?php

namespace Database\Factories;

use App\Models\Exchange;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExchangeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Exchange::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique->name,
            'slug' => $this->faker->unique->slug,
            'status' => $this->faker->word,
        ];
    }
}
