<?php

namespace App\Services\Tracks;

use App\Http\DTO\Tracks\Goal\{GoalDTO, UpdateGoalDTO};
use App\Models\Account;
use App\Models\Goal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GoalService
{
    public function index(Account $activeAccount): LengthAwarePaginator
    {
        return Goal::query()->where('account_id', $activeAccount->id)->with(['account'])->paginate(10);
    }

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
