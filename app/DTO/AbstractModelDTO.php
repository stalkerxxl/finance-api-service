<?php

namespace App\DTO;

use Illuminate\Support\Facades\Validator;
use JetBrains\PhpStorm\Pure;

abstract class AbstractModelDTO
{
    /**
     * description
     *
     * @return AbstractModelDTO
     */
    #[Pure]
    public static function make(): static
    {
        return new static();
    }

    protected static function validator($dto): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make((array)$dto, $dto->rules());
    }

    abstract public function rules(): array;
}
