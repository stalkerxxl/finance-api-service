<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Insider extends Model
{
    use HasFactory;
    use Searchable;

    protected $guarded = ['id'];

    protected array $searchableFields = ['*'];

    public function allTransactions(): HasMany
    {
        return $this->hasMany(Transactions::class);
    }
}
