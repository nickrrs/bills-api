<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Goal extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'goals';

    protected $fillable = [
        'id',
        'account_id',
        'title',
        'goal_color',
        'description',
        'status',
        'initial_value',
        'goal_value',
        'goal_conclusion_date',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
