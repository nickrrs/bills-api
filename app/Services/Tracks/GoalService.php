<?php

namespace App\Services\Tracks;

use App\Http\DTO\Tracks\Goal\{GoalDTO, UpdateGoalDTO};
use App\Models\Goal;

class GoalService
{
    public function store(GoalDTO $goalDTO): Goal
    {
        return Goal::create((array) $goalDTO);
    }

    public function update(Goal $goal, UpdateGoalDTO $goalDTO): Goal
    {
        $goal->update((array) $goalDTO);

        return $goal;
    }
}
