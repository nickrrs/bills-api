<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'cards';

    protected $fillable = [
        'id',
        'account_id',
        'limit',
        'close_day',
        'due_day',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
