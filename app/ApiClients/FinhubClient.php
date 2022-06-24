<?php

namespace App\ApiClients;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class FinhubClient
{

    private string $baseUrl;
    private string $token;

    public function __construct()
    {
        $this->baseUrl = config('services.finhub.base_url');
        $this->token = config('services.finhub.token');
    }

    public function companyProfile2($ticker): Response
    {
        $endpoint = '/stock/profile2';
        $params = [
            'symbol' => $ticker,
        ];

        return $this->callApi($endpoint, $params);
    }

    public function indexConstituents($indexName): Response
    {
        $endpoint = '/index/constituents';
        $params = [
            'symbol' => $indexName,
        ];

        return $this->callApi($endpoint, $params);
    }

    public function insiderTransactions($ticker = null): Response
    {
        $endpoint = '/stock/insider-transactions';
        $params = [
            'symbol' => $ticker,
        ];

        return $this->callApi($endpoint, $params);
    }

    public function earningsSurprises($ticker): Response
    {
        $endpoint = '/stock/earnings';
        $params = [
            'symbol' => $ticker,
        ];

        return $this->callApi($endpoint, $params);
    }

    public function earningsCalendar($ticker = null): Response
    {
        $endpoint = '/calendar/earnings';
        $params = [
            'symbol' => $ticker,
        ];

        return $this->callApi($endpoint, $params);
    }

    private function callApi($endpoint, $params): Response
    {
        $params['token'] = $this->token;

        return Http::get($this->baseUrl.$endpoint, $params);
    }
}
