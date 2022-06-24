<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'name' => 'admin',
                'role'=> 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
            ]);

      /*  $this->call(CompanySeeder::class);
        $this->call(ExchangeSeeder::class);
        $this->call(IndustrySeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(QuoteSeeder::class);
        $this->call(UserSeeder::class);*/
    }
}
