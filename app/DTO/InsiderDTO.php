<?php

namespace App\DTO;

use App\DTO\Response\EarningsCalendarDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Str;

/**
 * @property string $slug
 * @property string $name
 */
class InsiderDTO extends AbstractModelDTO
{

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
        ];
    }

    public function fromInsiderTransactions(EarningsCalendarDTO $data): Validator
    {
        $this->name = $data->name;
        $this->slug = Str::slug($this->name);

        return parent::validator($this);
    }
}
