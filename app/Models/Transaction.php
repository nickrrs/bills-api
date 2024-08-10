<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'transactions';

    protected $fillable = [
        'title',
        'source_type',
        'source_id',
        'transaction_type',
        'release_type',
        'categorie_id',
        'subcategorie_id',
        'value',
        'hasPaid',
        'hasReceived',
        'transaction_date',
    ];

    protected function casts(): array
    {
        return [
            'hasPaid' => 'boolean',
            'hasReceived' => 'boolean',
        ];
    }

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    public function subcategorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    public function source(): MorphTo
    {
        return $this->morphTo();
    }
}
