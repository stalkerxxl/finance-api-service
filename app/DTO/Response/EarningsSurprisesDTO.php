<?php

namespace App\DTO\Response;

/**
 * @property string|null $symbol
 * @property float|null $surprisePercent
 * @property float|null $surprise
 * @property string|null $period
 * @property float|null $estimate
 * @property float|null $actual
 */
class EarningsSurprisesDTO
{
    public static function make($json): EarningsSurprisesDTO
    {
        $dto = new self();
        $dto->mappedData($json);

        return $dto;
    }

    private function mappedData($json): void
    {
        $this->actual = is_numeric($json['actual']) ? (float)$json['actual'] : null;
        $this->estimate = is_numeric($json['estimate']) ? (float)$json['estimate'] : null;
        $this->period = is_string($json['period']) ? $json['period'] : null;
        $this->surprise = is_numeric($json['surprise']) ? (float)$json['surprise'] : null;
        $this->surprisePercent = is_numeric(
            $json['surprisePercent']
        ) ? (float)$json['surprisePercent'] : null;
        $this->symbol = is_string($json['symbol']) ? $json['symbol'] : null;
    }
}
