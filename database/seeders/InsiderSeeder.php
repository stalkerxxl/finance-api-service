<?php

namespace Database\Seeders;

use App\Models\Insider;
use Illuminate\Database\Seeder;

class InsiderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Insider::factory()
            ->count(5)
            ->create();
    }
}
