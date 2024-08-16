<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Account extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'accounts';

    protected $fillable = [
        'id',
        'user_id',
        'balance',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }

    public function limits(): HasMany
    {
        return $this->hasMany(Limit::class);
    }

    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class);
    }
}
