<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = News::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category' => $this->faker->text(255),
            'timestamp' => $this->faker->dateTime,
            'headline' => $this->faker->text(255),
            'source' => $this->faker->text(255),
            'summary' => $this->faker->text,
            'news_url' => $this->faker->text(255),
            'company_id' => \App\Models\Company::factory(),
        ];
    }
}
