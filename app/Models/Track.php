<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Track extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'tracks';

    protected $fillable = [
        'id',
        'account_id',
        'title',
        'track_type',
        'actual_value',
        'goal_value',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
