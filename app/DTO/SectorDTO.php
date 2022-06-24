<?php

namespace App\DTO;

use App\DTO\Responses\CompanyOverviewDTO;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * @property string $name
 * @property string $slug
 */
class SectorDTO extends AbstractModelDTO
{

    /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'slug' => [
                'required', 'string',
                Rule::unique('sectors')->ignore($this->name, 'name'),
            ],
        ];
    }

    /**
     * @param  CompanyOverviewDTO  $data
     * @return void
     */
    public function mappedFromAPI(CompanyOverviewDTO $data): void
    {
        $this->name = $data->sectorName;
        $this->slug = Str::slug($this->name, '-');
    }
}
