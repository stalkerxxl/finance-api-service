<?php

namespace Database\Factories;

use App\Models\Quote;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Quote::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'current_price' => $this->faker->randomNumber(2),
            'change_day' => $this->faker->randomNumber(2),
            'change_percent' => $this->faker->randomNumber(2),
            'high_day' => $this->faker->randomNumber(2),
            'low_day' => $this->faker->randomNumber(2),
            'open_day' => $this->faker->randomNumber(2),
            'previous_close' => $this->faker->randomNumber(2),
            'quote_time' => $this->faker->dateTime,
            'company_id' => \App\Models\Company::factory(),
        ];
    }
}
