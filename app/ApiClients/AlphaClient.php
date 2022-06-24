<?php

namespace App\ApiClients;

use App\Models\Token;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class AlphaClient
{
    private const SERVICE_NAME = Token::ALPHA_API;
    public null|Builder|Model $apiSettings;

    public function __construct()
    {
        $this->apiSettings = Token::query()
            ->where(['api_name' => self::SERVICE_NAME, 'is_active' => true])
            ->oldest('updated_at')->first();
        $this->apiSettings->increment('today_count');
        $this->apiSettings->increment('total_count');
    }

    public function companyOverview($ticker): Response
    {
        $params = [
            'function' => 'OVERVIEW',
            'symbol' => $ticker,
        ];

        return $this->callApi($params);
    }

    private function callApi($params): Response
    {
        $params['apikey'] = $this->apiSettings->api_key;

        return Http::get($this->apiSettings->base_url, $params);
    }
}
