<?php

namespace Database\Factories;

use App\Models\Insider;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class InsiderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Insider::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique->name,
        ];
    }
}
