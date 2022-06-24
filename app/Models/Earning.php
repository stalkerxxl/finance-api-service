<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{

    protected $guarded = ['id'];

    protected $casts = [
        'eps_actual' => 'decimal:4',
        'eps_estimate' => 'decimal:4',
    ];

}
