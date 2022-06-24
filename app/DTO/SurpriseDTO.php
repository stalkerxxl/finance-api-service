<?php

namespace App\DTO;

use App\DTO\Response\CompanyProfile2DTO;
use App\DTO\Response\EarningsCalendarDTO;
use App\DTO\Response\EarningsSurprisesDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * @property float|null $surprise_percent
 * @property float|null $surprise
 * @property string|null $period
 * @property float|null $estimate
 * @property float|null $actual
 */
class SurpriseDTO extends AbstractModelDTO
{

    /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
    public function rules(): array
    {
        return [
            'actual' => ['required', 'numeric'],
            'estimate' => ['required', 'numeric'],
            'period'=>['required', 'date_format:"Y-m-d"'],
            'surprise' => ['required', 'numeric'],
            'surprise_percent' => ['required', 'numeric'],
        ];
    }


    public function fromEarningsSurprises( EarningsSurprisesDTO$data): Validator
    {
        $this->actual = $data->actual;
        $this->estimate = $data->estimate;
        $this->period = $data->period;
        $this->surprise = $data->surprise;
        $this->surprise_percent = $data->surprisePercent;

        return parent::validator($this);
    }
}
