<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transactions extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'company_id',
        'insider_id',
        'share',
        'change',
        'filling_date',
        'transaction_date',
        'transaction_code',
        'transaction_price',
        'is_active',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'filling_date' => 'date',
        'transaction_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function insider()
    {
        return $this->belongsTo(Insider::class);
    }
}
