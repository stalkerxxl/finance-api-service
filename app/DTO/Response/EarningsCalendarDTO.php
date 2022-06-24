<?php

namespace App\DTO\Response;

/**
 * @property float|null $year
 * @property string|null $symbol
 * @property float|null $revenueEstimate
 * @property float|null $revenueActual
 * @property float|null $quarter
 * @property string|null $hour
 * @property float|null $epsEstimate
 * @property float|null $epsActual
 * @property string|null $date
 */
class EarningsCalendarDTO
{
    public static function make($json): EarningsCalendarDTO
    {
        $dto = new self();
        $dto->mappedData($json);

        return $dto;
    }

    private function mappedData($json): void
    {
        $this->date = is_string($json['date']) ? $json['date'] : null;
        $this->epsActual = is_numeric($json['epsActual']) ? (float)$json['epsActual'] : null;
        $this->epsEstimate = is_numeric($json['epsEstimate']) ? (float)$json['epsEstimate'] : null;
        $this->hour = is_string($json['hour']) ? $json['hour'] : null;
        $this->quarter = is_numeric($json['quarter']) ? (float)$json['quarter'] : null;
        $this->revenueActual = is_numeric($json['revenueActual']) ? (float)$json['revenueActual'] : null;
        $this->revenueEstimate = is_numeric($json['revenueEstimate']) ? (float)$json['revenueEstimate'] : null;
        $this->symbol = is_string($json['symbol']) ? $json['symbol'] : null;
        $this->year = is_numeric($json['year']) ? (float)$json['year'] : null;

    }
}
