<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quote extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'company_id',
        'current_price',
        'change_day',
        'change_percent',
        'high_day',
        'low_day',
        'open_day',
        'previous_close',
        'quote_time',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'quote_time' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
