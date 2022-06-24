<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Transactions;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transactions::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'share' => $this->faker->randomNumber,
            'change' => $this->faker->randomNumber,
            'filling_date' => $this->faker->date,
            'transaction_date' => $this->faker->date,
            'transaction_code' => $this->faker->text(255),
            'transaction_price' => $this->faker->randomNumber(2),
            'company_id' => \App\Models\Company::factory(),
            'insider_id' => \App\Models\Insider::factory(),
        ];
    }
}
