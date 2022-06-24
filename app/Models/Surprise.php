<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surprise extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'actual' => 'decimal:4',
        'estimate' => 'decimal:4',
        'surprise' => 'decimal:4',
        'surprise_percent' => 'decimal:4',
    ];
}
