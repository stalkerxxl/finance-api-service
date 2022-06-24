<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    public const ALPHA_API = 'alpha';

    public const FINHUB_API = 'finhub';

    protected $guarded = ['id'];

    public static function getApiNameList(): array
    {
        return [
            self::ALPHA_API,
            self::FINHUB_API,
        ];
    }
}
