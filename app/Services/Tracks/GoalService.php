<?php

namespace App\Services\Tracks;

use App\Http\DTO\Tracks\Goal\GoalDTO;
use App\Models\Goal;

class GoalService
{
    public function store(GoalDTO $goalDTO): Goal
    {
        return Goal::create((array) $goalDTO);
    }
}
