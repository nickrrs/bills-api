<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, MorphTo};

class Transaction extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'transactions';

    protected $fillable = [
        'title',
        'source_type',
        'source_id',
        'transaction_type',
        'release_type',
        'category_id',
        'subcategory_id',
        'value',
        'hasPaid',
        'hasReceived',
        'transaction_date',
    ];

    protected function casts(): array
    {
        return [
            'hasPaid'     => 'boolean',
            'hasReceived' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function source(): MorphTo
    {
        return $this->morphTo();
    }
}
