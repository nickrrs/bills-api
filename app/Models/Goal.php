<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Number;

/**
 * @property int $id
 * @property-read string $value_to_invest
 * @property-read float $percentage
 */
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
        'actual_value',
        'goal_value',
        'goal_conclusion_date',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    protected function valueToInvest(): Attribute
    {
        return Attribute::make(
            get: function () {
                $conclusionDate = Carbon::parse($this->goal_conclusion_date);
                $monthsLeft = Carbon::now()->diffInMonths($conclusionDate);

                $valueToInvest = ($this->goal_value - $this->actual_value) / intval($monthsLeft);
                return Number::format($valueToInvest, 2);
            },
        );
    }

    protected function percentage(): Attribute
    {
        return Attribute::make(
            get: function () {
                $percentageAchieved = ($this->actual_value / $this->goal_value) * 100;
                return round($percentageAchieved, 2);
            }
        );
    }

    public static function closestExpiringGoal(): ?self
    {
        return self::where('goal_conclusion_date', '>', Carbon::now())
            ->orderBy('goal_conclusion_date', 'asc')
            ->first();
    }

    public static function totalInvested(): ?string
    {
        return self::sum('actual_value');
    }

    public static function totalGoals(): ?string
    {
        return self::sum('goal_value');
    }
}
