<?php

namespace App\DTO\Response;

/**
 * @property string|null $symbol
 * @property string|null $name
 * @property float|null $transactionPrice
 * @property string|null $transactionCode
 * @property string|null $transactionDate
 * @property string|null $filingDate
 * @property integer|null $change
 * @property integer|null $share
 */
class InsiderTransactionsDTO
{
    public static function make($json): EarningsCalendarDTO
    {
        $dto = new self();
        $dto->mappedData($json);

        return $dto;
    }

    private function mappedData($json): void
    {
        $this->symbol = is_string($json['symbol']) ? $json['symbol'] : null;
        $this->name = is_string($json['name']) ? $json['name'] : null;
        $this->share = is_numeric($json['share']) ? $json['share'] : null;
        $this->change = is_numeric($json['change']) ? $json['change'] : null;
        $this->filingDate = is_string($json['filingDate']) ? $json['filingDate'] : null;
        $this->transactionDate = is_string($json['transactionDate']) ? $json['transactionDate'] : null;
        $this->transactionCode = is_string($json['transactionCode']) ? $json['transactionCode'] : null;
        $this->transactionPrice = is_numeric($json['transactionPrice']) ? (float)$json['transactionPrice'] : null;
    }
}
