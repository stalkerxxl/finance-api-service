<?php

namespace App\DTO;

use App\DTO\Response\CompanyProfile2DTO;
use App\DTO\Response\EarningsCalendarDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


/**
 * @property float|null $year
 * @property float|null $revenue_estimate
 * @property float|null $revenue_actual
 * @property float|null $quarter
 * @property string|null $hour
 * @property float|null $eps_estimate
 * @property float|null $eps_actual
 * @property string|null $date
 */
class EarningDTO extends AbstractModelDTO
{

    /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date_format:"Y-m-d"'],
            'eps_actual' => ['numeric', 'nullable'],
            'eps_estimate' => ['numeric', 'nullable'],
            'hour' => ['required', 'string'],
            'quarter' => ['required', 'numeric'],
            'revenue_actual' => ['numeric', 'nullable'],
            'revenue_estimate' => ['numeric', 'nullable'],
            'year' => ['required', 'date_format:"Y"'],
        ];
    }


    public function fromEarningsCalendar(EarningsCalendarDTO $data): Validator
    {
        $this->date = $data->date;
        $this->eps_actual = $data->epsActual;
        $this->eps_estimate = $data->epsEstimate;
        $this->hour = $data->hour;
        $this->quarter = $data->quarter;
        $this->revenue_actual = $data->revenueActual;
        $this->revenue_estimate = $data->revenueEstimate;
        $this->year = $data->year;

        return parent::validator($this);
    }
}
