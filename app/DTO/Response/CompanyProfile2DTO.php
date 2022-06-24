<?php

namespace App\DTO\Response;

/**
 * @property string|null $country
 * @property string|null $currency
 * @property string|null $exchange
 * @property string|null $weburl
 * @property string|null $ticker
 * @property int|null $shareOutstanding
 * @property float|null $phone
 * @property string|null $name
 * @property int|null $marketCapitalization
 * @property string|null $logo
 * @property string|null $ipo
 * @property string|null $finnhubIndustry
 */
class CompanyProfile2DTO
{

    public static function make($json): CompanyProfile2DTO
    {
        $dto = new self();
        $dto->mappedData($json);

        return $dto;
    }

    private function mappedData($json): void
    {
        $this->country = is_string($json['country']) ? $json['country'] : null;
        $this->currency = is_string($json['currency']) ? $json['currency'] : null;
        $this->exchange = is_string($json['exchange']) ? $json['exchange'] : null;
        $this->finnhubIndustry = is_string($json['finnhubIndustry']) ? $json['finnhubIndustry'] : null;
        $this->ipo = is_string($json['ipo']) ? $json['ipo'] : null;
        $this->logo = is_string($json['logo']) ? $json['logo'] : null;
        $this->marketCapitalization = is_numeric(
            $json['marketCapitalization']
        ) ? (float)$json['marketCapitalization'] : null;
        $this->name = is_string($json['name']) ? $json['name'] : null;
        $this->phone = is_numeric($json['phone']) ? (float)$json['phone'] : null;
        $this->shareOutstanding = is_numeric($json['shareOutstanding']) ? (float)$json['shareOutstanding'] : null;
        $this->ticker = is_string($json['ticker']) ? $json['ticker'] : null;
        $this->weburl = is_string($json['weburl']) ? $json['weburl'] : null;
    }

}
