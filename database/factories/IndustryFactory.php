<?php

namespace Database\Factories;

use App\Models\Industry;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class IndustryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Industry::class;

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
        ];
    }
}
