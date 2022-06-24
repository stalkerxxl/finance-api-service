<?php

namespace Database\Seeders;

use App\Models\Token;

use Illuminate\Database\Seeder;

class TokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $alphaData = $this->getAlphaData();
        foreach ($alphaData as $datum){
            Token::factory()->set('api_name', Token::ALPHA_API)
                ->set('base_url', 'https://www.alphavantage.co/query')
                ->set('is_active', true)
                ->create($datum);
        }

    }

    public function getAlphaData(): array
    {
        return [
            ['email' => 'stalkerxxl@gmail.com', 'api_key' => 'F4OR5XS7YC15C8LT'],
            ['email' => 'stalkerxxl+1@gmail.com', 'api_key'=>'5FGSDMXSUZ3HCXDQ'],
            ['email' => '173283+1@gmail.com', 'api_key'=>'N8Z5NWWICK1D3T7N'],
            ['email' => '173283+2@gmail.com', 'api_key'=>'1KX0FG4MABZ04GZJ'],
            ['email' => '173283+3@gmail.com', 'api_key'=>'J3VRMQ9KHOFZ0U6J'],
            ['email' => '173283+4@gmail.com', 'api_key'=>'BGQMNN0IPUPA6E29'],
            ['email' => '173283+5@gmail.com', 'api_key'=>'WE09HUNM893N1ZNZ'],
            ['email' => '173283+6@gmail.com', 'api_key'=>'SBY9TM9LTC5X6SBI'],
            ['email' => '173283+7@gmail.com', 'api_key'=>'HUWUH5Q8TDHP31VL'],
            ['email' => '173283+8@gmail.com', 'api_key'=>'7MRL16PWSPRQ5PH0'],
            ['email' => '173283+9@gmail.com', 'api_key'=>'9D5CZBT7SIOKZZ4N'],
            ['email' => '173283+10@gmail.com', 'api_key'=>'6G790ZS600LR57OH'],
            ['email' => '173283+11@gmail.com', 'api_key'=>'5FSJERGNXI5T9OUI'],
            ['email' => '173283+12@gmail.com', 'api_key'=>'8SDA84RPVZ2OLH7P'],
            ['email' => '173283+13@gmail.com', 'api_key'=>'4O0JMBP2I94C831U'],
            ['email' => '173283+14@gmail.com', 'api_key'=>'ZH28JUVFSD81U34C'],
            ['email' => '173283+15@gmail.com', 'api_key'=>'SJYJSIYZG6TCJAIF'],
            ['email' => '173283+16@gmail.com', 'api_key'=>'PYM1MPXCDXDP5V64'],
            ['email' => '173283+17@gmail.com', 'api_key'=>'PRE5UHF4W4P7K0CV'],
            ['email' => '173283+18@gmail.com', 'api_key'=>'ZNHRDMVAQK5366P8'],
            ['email' => '173283+19@gmail.com', 'api_key'=>'BLI82IRFPHHI6ZOS'],
            ['email' => '173283+20@gmail.com', 'api_key'=>'JTTYYV8OO1WFJX0T'],


        ];
    }
}
