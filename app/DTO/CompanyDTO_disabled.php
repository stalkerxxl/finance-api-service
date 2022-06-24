<?php

namespace App\DTO;

use App\Models\Company;
use App\Models\Exchange;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class CompanyDTOFinhub
{

    private static function rules(): array
    {
        return [
            'exchange_id' => ['required', 'integer'],
            'industry_id' => ['required', 'integer'],
            'ticker' => ['required', 'string'],
            'name' => ['required', 'max:255', 'string',],
            'slug' => ['required', 'max:255', 'string',],
            'country' => ['required', 'max:255', 'string'],
            'currency' => ['required', 'max:4', 'string'],
            'fast_price' => ['nullable', 'numeric'],
            'ipo_date' => ['required', 'date'],
            'logo' => ['nullable', 'max:255', 'string'],
            'logo_api_url' => ['nullable', 'max:255', 'string'],
            'market_cap' => ['nullable', 'numeric'],
            'phone' => ['nullable', 'max:255', 'string'],
            'shares_out' => ['required', 'numeric'],
            'web_url' => ['nullable', 'max:255', 'string'],
            'metric' => ['nullable', 'json'],
            'is_active' => ['boolean']
        ];
    }

    /**
     * @param  Collection  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function make(Collection $data): \Illuminate\Contracts\Validation\Validator
    {
        $prepareData = self::prepareForValidation($data);
        return Validator::make($prepareData, self::rules());
    }

    private static function prepareForValidation(Collection $data): array
    {
        $dto = new Company();
        $dto->exchange_id = is_numeric($data['exchange_id']) ? (int) $data['exchange_id'] : null;
        $dto->industry_id = is_numeric($data['industry_id']) ? (int) $data['industry_id'] : null;
        $dto->ticker = is_string($data['ticker']) ? $data['ticker'] : null;
        $dto->name = is_string($data['name']) ? $data['name'] : null;
        $dto->slug = Str::slug($dto->name, '-');
        $dto->country = is_string($data['country']) ? $data['country'] : null;
        $dto->currency = is_string($data['currency']) ? $data['currency'] : null;
        //TODO возможно лучше вынести в мутатор модели?
        $dto->fast_price = $data['marketCapitalization'] / $data['shareOutstanding'];
        $dto->ipo_date = is_string($data['ipo']) ? $data['ipo'] : null;
        $dto->logo_api_url = is_string($data['logo']) ? $data['logo'] : null; //FIXME продумать загрузку logo
        $dto->market_cap = is_numeric($data['marketCapitalization']) ? (float) $data['marketCapitalization'] * 1000 : null;
        $dto->phone = is_string($data['phone']) ? $data['phone'] : null;
        $dto->shares_out = is_numeric($data['shareOutstanding']) ? (float) $data['shareOutstanding'] * 1000 : null;
        $dto->web_url = is_string($data['weburl']) ? $data['weburl'] : null;
        $dto->is_active = true;


        return $dto->toArray();
    }
}
