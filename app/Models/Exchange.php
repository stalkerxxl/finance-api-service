<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exchange extends Model
{
    use HasFactory;
    use Searchable;

    protected $withCount = ['companies'];

    protected $guarded = ['id'];

    protected array $searchableFields = ['*'];

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }
}
