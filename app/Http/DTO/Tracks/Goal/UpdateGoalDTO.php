<?php

namespace App\Http\DTO\Tracks\Goal;

use App\Traits\FillableFromArray;

class UpdateGoalDTO
{
    use FillableFromArray;

    public $title;

    public $goal_color;

    public $description;

    public $status;

    public $actual_value;

    public $goal_value;

    public $goal_conclusion_date;

    public $account_id;

    public function __construct(array $data, $existingData = [])
    {
        $this->fillFromArray($data, $existingData);
    }
}
