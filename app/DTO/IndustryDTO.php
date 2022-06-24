<?php

namespace App\DTO;

use App\DTO\Response\CompanyProfile2DTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * @property string $name
 * @property string $slug
 */
class IndustryDTO extends AbstractModelDTO
{

    /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'slug' => [
                'required', 'string',
                Rule::unique('industries')->ignore($this->name, 'name'),
            ],
            'is_active' => ['boolean', 'nullable'],
            'status' => ['string', 'nullable'],
        ];
    }


    public function fromCompanyProfile2(CompanyProfile2DTO $data): Validator
    {
        $this->name = $data->finnhubIndustry;
        $this->slug = Str::slug($this->name, '-');

        return parent::validator($this);
    }
}
