<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    use Searchable;

    protected $guarded = ['id'];

    protected array $searchableFields = ['*'];

    protected $casts = [
        'ipo_date' => 'date',
        'fin_data' => 'array',
        'is_active' => 'boolean',
    ];

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    public function exchange(): BelongsTo
    {
        return $this->belongsTo(Exchange::class);
    }

    public function quote(): HasOne
    {
        return $this->hasOne(Quote::class);
    }

    public function allNews(): HasMany
    {
        return $this->hasMany(News::class);
    }

    public function allTransactions(): HasMany
    {
        return $this->hasMany(Transactions::class);
    }

    //FIXME не работает... узнать в чате
    public function insiders(): HasManyThrough
    {
        return $this->hasManyThrough(Insider::class, Transactions::class);
    }
}
