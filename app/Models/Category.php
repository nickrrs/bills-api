<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Category extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'categories';

    protected $fillable = [
        'id',
        'account_id',
        'title',
        'color',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class);
    }

    public function limits(): HasMany
    {
        return $this->hasMany(Limit::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Limit::class);
    }
}
