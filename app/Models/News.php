<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'company_id',
        'category',
        'timestamp',
        'headline',
        'image_url',
        'source',
        'summary',
        'news_url',
        'is_active',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'timestamp' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
