<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ticker' => $this->faker->unique->text(255),
            'name' => $this->faker->unique->name,
            'country' => $this->faker->country,
            'currency' => $this->faker->currencyCode,
            'fast_price' => $this->faker->randomNumber(2),
            'ipo_date' => $this->faker->date,
            'logo' => $this->faker->text(255),
            'logo_api_url' => $this->faker->text(255),
            'market_cap' => $this->faker->randomNumber,
            'phone' => $this->faker->phoneNumber,
            'shares_out' => $this->faker->randomNumber,
            'web_url' => $this->faker->text(255),
            'metric' => [],
            'is_active' => $this->faker->boolean,
            'industry_id' => \App\Models\Industry::factory(),
            'exchange_id' => \App\Models\Exchange::factory(),
        ];
    }
}
