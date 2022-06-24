<?php

namespace App\DTO;

use App\DTO\Response\CompanyProfile2DTO;
use Illuminate\Contracts\Validation\Validator;

/**
 * @property float|int $fast_price
 * @property bool $is_active
 * @property string|null $web_url
 * @property float|int $shares_out
 * @property float|null $phone
 * @property float|int $market_cap
 * @property string|null $logo_api_url
 * @property string|null $ipo_date
 * @property string|null $currency
 * @property string|null $country
 * @property string|null $name
 * @property string|null $ticker
 */
class CompanyDTO extends AbstractModelDTO
{

    public function rules(): array
    {
        return [
            'ticker' => ['required', 'string'],
            'name' => ['required', 'max:255', 'string',],
            'country' => ['required', 'max:100', 'string'],
            'currency' => ['required', 'max:4', 'string'],
            'description' => ['string', 'nullable'],
            'fast_price' => ['nullable', 'numeric'],
            'ipo_date' => ['required', 'date'],
            'logo' => ['nullable', 'max:255', 'string'],
            'logo_api_url' => ['nullable', 'string'],
            'market_cap' => ['nullable', 'numeric'],
            'phone' => ['nullable', 'numeric'],
            'shares_out' => ['required', 'numeric'],
            'fin_data' => ['nullable', 'json'],
            'is_active' => ['boolean', 'nullable'],
        ];
    }


    public function fromCompanyProfile2(CompanyProfile2DTO $data): Validator
    {
        $this->ticker = $data->ticker;
        $this->name = $data->name;
        $this->country = $data->country;
        $this->currency = $data->currency;
        $this->ipo_date = $data->ipo;
        $this->logo_api_url = $data->logo;
        //FIXME может лучше вынести в мутаторы?
        $this->market_cap = $data->marketCapitalization * 1000;
        $this->phone = $data->phone;
        $this->shares_out = $data->shareOutstanding * 1000;
        $this->web_url = $data->weburl;
        $this->is_active = true;
        //TODO возможно лучше вынести в мутатор модели?
        $this->fast_price = $data->marketCapitalization / $data->shareOutstanding;

        return parent::validator($this);
    }
}
